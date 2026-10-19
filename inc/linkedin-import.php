<?php

/**
 * Imports positions from LinkedIn into the Experience post type.
 *
 * Uses the LinkedIn Member Data Portability (Member) API, which is only
 * available to members located in the EEA and Switzerland. Credentials come
 * from wp-config.php constants:
 *
 * - RICKMANU_LINKEDIN_CLIENT_ID
 * - RICKMANU_LINKEDIN_CLIENT_SECRET
 * - RICKMANU_LINKEDIN_SCOPE (optional, defaults to r_dma_portability_self_serve)
 *
 * The LinkedIn app must list admin_url( 'admin-post.php' ) as a redirect URL.
 * LinkedIn rejects redirect URLs with query strings, so the callback is
 * handled on the generic `admin_post` hook and identified by its state.
 *
 * @package rickmanu
 */

if (! defined('ABSPATH')) {
    exit;
}

const RICKMANU_LINKEDIN_AUTHORIZE_URL = 'https://www.linkedin.com/oauth/v2/authorization';
const RICKMANU_LINKEDIN_TOKEN_URL     = 'https://www.linkedin.com/oauth/v2/accessToken';
const RICKMANU_LINKEDIN_SNAPSHOT_URL  = 'https://api.linkedin.com/rest/memberSnapshotData';
const RICKMANU_LINKEDIN_API_VERSION   = '202312';
const RICKMANU_LINKEDIN_MAX_PAGES     = 20;

/**
 * Whether the LinkedIn app credentials are configured.
 */
function rickmanu_linkedin_is_configured(): bool
{
    return defined('RICKMANU_LINKEDIN_CLIENT_ID') && RICKMANU_LINKEDIN_CLIENT_ID
        && defined('RICKMANU_LINKEDIN_CLIENT_SECRET') && RICKMANU_LINKEDIN_CLIENT_SECRET;
}

/**
 * OAuth redirect URL registered in the LinkedIn app.
 */
function rickmanu_linkedin_redirect_uri(): string
{
    return admin_url('admin-post.php');
}

/**
 * Transient key holding the pending OAuth state for a user.
 */
function rickmanu_linkedin_state_key(int $user_id): string
{
    return 'rickmanu_linkedin_state_' . $user_id;
}

/**
 * Whether the current user may run the import.
 */
function rickmanu_linkedin_user_can_import(): bool
{
    $post_type = get_post_type_object(RICKMANU_EXPERIENCE_POST_TYPE);

    return $post_type && current_user_can($post_type->cap->create_posts);
}

/**
 * Renders the import button above the Experience list table.
 *
 * @param string $which Tablenav position, "top" or "bottom".
 */
function rickmanu_linkedin_render_button(string $which): void
{
    if ('top' !== $which || RICKMANU_EXPERIENCE_POST_TYPE !== get_current_screen()?->post_type) {
        return;
    }

    if (! rickmanu_linkedin_user_can_import()) {
        return;
    }

    if (! rickmanu_linkedin_is_configured()) {
        printf(
            '<div class="alignleft actions"><span class="button disabled" title="%1$s">%2$s</span></div>',
            esc_attr__('Define RICKMANU_LINKEDIN_CLIENT_ID and RICKMANU_LINKEDIN_CLIENT_SECRET in wp-config.php.', 'rickmanu'),
            esc_html__('Import from LinkedIn (not configured)', 'rickmanu')
        );
        return;
    }

    $url = wp_nonce_url(
        admin_url('admin-post.php?action=rickmanu_linkedin_connect'),
        'rickmanu_linkedin_connect'
    );

    printf(
        '<div class="alignleft actions"><a href="%1$s" class="button button-primary">%2$s</a></div>',
        esc_url($url),
        esc_html__('Import from LinkedIn', 'rickmanu')
    );
}
add_action('manage_posts_extra_tablenav', 'rickmanu_linkedin_render_button');

/**
 * Redirects back to the Experience list with a result code.
 *
 * @param array<string, int|string> $args Extra query args.
 */
function rickmanu_linkedin_redirect_back(string $result, array $args = []): never
{
    $url = add_query_arg(
        array_merge(['post_type' => RICKMANU_EXPERIENCE_POST_TYPE, 'rickmanu_linkedin' => $result], $args),
        admin_url('edit.php')
    );

    wp_safe_redirect($url);
    exit;
}

/**
 * Starts the OAuth flow: stores a state and sends the user to LinkedIn.
 */
function rickmanu_linkedin_connect(): void
{
    check_admin_referer('rickmanu_linkedin_connect');

    if (! rickmanu_linkedin_user_can_import()) {
        wp_die(esc_html__('You are not allowed to import experience.', 'rickmanu'), 403);
    }

    if (! rickmanu_linkedin_is_configured()) {
        rickmanu_linkedin_redirect_back('not_configured');
    }

    $state = wp_generate_password(32, false);
    set_transient(rickmanu_linkedin_state_key(get_current_user_id()), $state, 10 * MINUTE_IN_SECONDS);

    $scope = defined('RICKMANU_LINKEDIN_SCOPE') && RICKMANU_LINKEDIN_SCOPE
        ? RICKMANU_LINKEDIN_SCOPE
        : 'r_dma_portability_self_serve';

    $url = add_query_arg(
        rawurlencode_deep([
            'response_type' => 'code',
            'client_id'     => RICKMANU_LINKEDIN_CLIENT_ID,
            'redirect_uri'  => rickmanu_linkedin_redirect_uri(),
            'state'         => $state,
            'scope'         => $scope,
        ]),
        RICKMANU_LINKEDIN_AUTHORIZE_URL
    );

    // External host, so wp_safe_redirect() does not apply.
    wp_redirect($url); // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
    exit;
}
add_action('admin_post_rickmanu_linkedin_connect', 'rickmanu_linkedin_connect');

/**
 * Handles the OAuth callback, then fetches and imports the positions.
 *
 * Runs on the generic `admin_post` hook (no action param); requests without
 * our pending state are ignored so other handlers are not affected.
 */
function rickmanu_linkedin_callback(): void
{
    // phpcs:disable WordPress.Security.NonceVerification.Recommended -- The OAuth state is the CSRF token.
    $state = isset($_GET['state']) ? sanitize_text_field(wp_unslash($_GET['state'])) : '';
    $code  = isset($_GET['code']) ? sanitize_text_field(wp_unslash($_GET['code'])) : '';
    $error = isset($_GET['error']) ? sanitize_key(wp_unslash($_GET['error'])) : '';
    // phpcs:enable

    if ('' === $state) {
        return;
    }

    $key      = rickmanu_linkedin_state_key(get_current_user_id());
    $expected = get_transient($key);

    if (! is_string($expected) || ! hash_equals($expected, $state)) {
        return;
    }

    delete_transient($key);

    if (! rickmanu_linkedin_user_can_import()) {
        wp_die(esc_html__('You are not allowed to import experience.', 'rickmanu'), 403);
    }

    if ('' !== $error || '' === $code) {
        rickmanu_linkedin_redirect_back('denied');
    }

    $token = rickmanu_linkedin_exchange_code($code);

    if (is_wp_error($token)) {
        rickmanu_linkedin_log_error($token);
        rickmanu_linkedin_redirect_back('token_error');
    }

    $positions = rickmanu_linkedin_fetch_positions($token);

    if (is_wp_error($positions)) {
        rickmanu_linkedin_log_error($positions);
        rickmanu_linkedin_redirect_back('api_error');
    }

    $counts = rickmanu_linkedin_import_positions($positions);

    rickmanu_linkedin_redirect_back('imported', [
        'rickmanu_created' => $counts['created'],
        'rickmanu_updated' => $counts['updated'],
        'rickmanu_skipped' => $counts['skipped'],
    ]);
}
add_action('admin_post', 'rickmanu_linkedin_callback');

/**
 * Exchanges the authorization code for an access token.
 *
 * @return string|WP_Error Access token.
 */
function rickmanu_linkedin_exchange_code(string $code): string|WP_Error
{
    $response = wp_remote_post(RICKMANU_LINKEDIN_TOKEN_URL, [
        'timeout' => 15,
        'body'    => [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => RICKMANU_LINKEDIN_CLIENT_ID,
            'client_secret' => RICKMANU_LINKEDIN_CLIENT_SECRET,
            'redirect_uri'  => rickmanu_linkedin_redirect_uri(),
        ],
    ]);

    if (is_wp_error($response)) {
        return $response;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    if (200 !== wp_remote_retrieve_response_code($response) || empty($body['access_token'])) {
        return new WP_Error(
            'rickmanu_linkedin_token',
            sprintf('Token request failed (HTTP %d): %s', wp_remote_retrieve_response_code($response), wp_remote_retrieve_body($response))
        );
    }

    return (string) $body['access_token'];
}

/**
 * Fetches every POSITIONS snapshot entry, following pagination.
 *
 * LinkedIn says the paging total is unreliable and pages should be read
 * until it answers with an error, so a 404 after the first page ends the loop.
 *
 * @return array<int, array<string, string>>|WP_Error
 */
function rickmanu_linkedin_fetch_positions(string $token): array|WP_Error
{
    $positions = [];

    for ($start = 0; $start < RICKMANU_LINKEDIN_MAX_PAGES; $start++) {
        $url = add_query_arg(
            ['q' => 'criteria', 'domain' => 'POSITIONS', 'start' => $start],
            RICKMANU_LINKEDIN_SNAPSHOT_URL
        );

        $response = wp_remote_get($url, [
            'timeout' => 20,
            'headers' => [
                'Authorization'    => 'Bearer ' . $token,
                'LinkedIn-Version' => RICKMANU_LINKEDIN_API_VERSION,
            ],
        ]);

        if (is_wp_error($response)) {
            return $response;
        }

        $status = wp_remote_retrieve_response_code($response);

        if (404 === $status && $start > 0) {
            break;
        }

        if (200 !== $status) {
            return new WP_Error(
                'rickmanu_linkedin_api',
                sprintf('Snapshot request failed (HTTP %d): %s', $status, wp_remote_retrieve_body($response))
            );
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);

        foreach ($body['elements'] ?? [] as $element) {
            foreach ($element['snapshotData'] ?? [] as $entry) {
                if (is_array($entry)) {
                    $positions[] = $entry;
                }
            }
        }

        $has_next = false;
        foreach ($body['paging']['links'] ?? [] as $link) {
            if ('next' === ($link['rel'] ?? '')) {
                $has_next = true;
            }
        }

        if (! $has_next) {
            break;
        }
    }

    return $positions;
}

/**
 * Parses a LinkedIn month such as "Oct 2025" into a timestamp, or 0.
 */
function rickmanu_linkedin_parse_month(string $value): int
{
    $value = trim($value);

    if ('' === $value) {
        return 0;
    }

    $date = DateTimeImmutable::createFromFormat('!M Y', $value)
        ?: DateTimeImmutable::createFromFormat('!Y-m', $value)
        ?: DateTimeImmutable::createFromFormat('!Y', $value);

    return $date ? $date->getTimestamp() : 0;
}

/**
 * Creates or updates one Experience post per LinkedIn position.
 *
 * Positions are matched by their LinkedIn key first, then by company and
 * role, so entries created by hand are updated instead of duplicated.
 * The "group" field is left untouched because LinkedIn has no equivalent.
 *
 * @param array<int, array<string, string>> $positions Snapshot entries.
 * @return array{created: int, updated: int, skipped: int}
 */
function rickmanu_linkedin_import_positions(array $positions): array
{
    $counts = ['created' => 0, 'updated' => 0, 'skipped' => 0];
    $rows   = [];

    foreach ($positions as $position) {
        $company = trim((string) ($position['Company Name'] ?? ''));
        $role    = trim((string) ($position['Title'] ?? ''));

        if ('' === $company || '' === $role) {
            $counts['skipped']++;
            rickmanu_linkedin_log_error(new WP_Error(
                'rickmanu_linkedin_format',
                'Skipped position with unexpected keys: ' . implode(', ', array_keys($position))
            ));
            continue;
        }

        $started  = trim((string) ($position['Started On'] ?? ''));
        $finished = trim((string) ($position['Finished On'] ?? ''));

        $rows[] = [
            'company' => $company,
            'role'    => $role,
            'summary' => trim((string) ($position['Description'] ?? '')),
            'period'  => sprintf(
                /* translators: 1: start month, 2: end month or "Current". */
                __('%1$s — %2$s', 'rickmanu'),
                $started,
                '' !== $finished ? $finished : __('Current', 'rickmanu')
            ),
            'current' => '' === $finished,
            'start'   => rickmanu_linkedin_parse_month($started),
            'key'     => md5(strtolower($company . '|' . $role . '|' . $started)),
        ];
    }

    // Most recent first, matching the menu_order the front page sorts by.
    usort($rows, static fn(array $a, array $b): int => $b['start'] <=> $a['start']);

    foreach ($rows as $order => $row) {
        $post_id = rickmanu_linkedin_find_existing($row['key'], $row['company'], $row['role']);

        $postarr = [
            'post_type'   => RICKMANU_EXPERIENCE_POST_TYPE,
            'post_status' => 'publish',
            'post_title'  => $row['company'],
            'menu_order'  => $order,
        ];

        if ($post_id) {
            $postarr['ID'] = $post_id;
            $result        = wp_update_post(wp_slash($postarr), true);
        } else {
            $result = wp_insert_post(wp_slash($postarr), true);
        }

        if (is_wp_error($result) || ! $result) {
            $counts['skipped']++;
            continue;
        }

        $counts[$post_id ? 'updated' : 'created']++;

        $meta = [
            'period'       => $row['period'],
            'role'         => $row['role'],
            'summary'      => $row['summary'],
            'current'      => $row['current'] ? '1' : '0',
            'linkedin_key' => $row['key'],
        ];

        foreach ($meta as $meta_key => $value) {
            update_post_meta($result, $meta_key, wp_slash($value));
        }
    }

    return $counts;
}

/**
 * Finds an Experience post for a position, or 0.
 */
function rickmanu_linkedin_find_existing(string $key, string $company, string $role): int
{
    $base = [
        'post_type'      => RICKMANU_EXPERIENCE_POST_TYPE,
        'post_status'    => 'any',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'no_found_rows'  => true,
    ];

    $ids = get_posts($base + [
        'meta_key'   => 'linkedin_key', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
        'meta_value' => $key, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
    ]);

    if ($ids) {
        return (int) $ids[0];
    }

    $ids = get_posts($base + [
        'title'      => $company,
        'meta_key'   => 'role', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
        'meta_value' => $role, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
    ]);

    return $ids ? (int) $ids[0] : 0;
}

/**
 * Writes an import error to the debug log when WP_DEBUG_LOG is on.
 */
function rickmanu_linkedin_log_error(WP_Error $error): void
{
    if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
        error_log('[rickmanu LinkedIn import] ' . $error->get_error_message()); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
}

/**
 * Shows the import result on the Experience list screen.
 */
function rickmanu_linkedin_admin_notice(): void
{
    if (RICKMANU_EXPERIENCE_POST_TYPE !== get_current_screen()?->post_type) {
        return;
    }

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display only.
    $result = isset($_GET['rickmanu_linkedin']) ? sanitize_key(wp_unslash($_GET['rickmanu_linkedin'])) : '';

    if ('' === $result) {
        return;
    }

    if ('imported' === $result) {
        // phpcs:disable WordPress.Security.NonceVerification.Recommended -- Display only.
        $created = absint($_GET['rickmanu_created'] ?? 0);
        $updated = absint($_GET['rickmanu_updated'] ?? 0);
        $skipped = absint($_GET['rickmanu_skipped'] ?? 0);
        // phpcs:enable

        $message = sprintf(
            /* translators: 1: created count, 2: updated count, 3: skipped count. */
            __('LinkedIn import finished: %1$d created, %2$d updated, %3$d skipped.', 'rickmanu'),
            $created,
            $updated,
            $skipped
        );

        wp_admin_notice($message, [
            'type'        => $skipped ? 'warning' : 'success',
            'dismissible' => true,
        ]);
        return;
    }

    $messages = [
        'not_configured' => __('LinkedIn import is not configured. Define RICKMANU_LINKEDIN_CLIENT_ID and RICKMANU_LINKEDIN_CLIENT_SECRET in wp-config.php.', 'rickmanu'),
        'denied'         => __('LinkedIn authorization was cancelled or denied.', 'rickmanu'),
        'token_error'    => __('Could not get an access token from LinkedIn. See the debug log for details.', 'rickmanu'),
        'api_error'      => __('Could not read your positions from LinkedIn. See the debug log for details.', 'rickmanu'),
    ];

    if (isset($messages[$result])) {
        wp_admin_notice($messages[$result], ['type' => 'error', 'dismissible' => true]);
    }
}
add_action('admin_notices', 'rickmanu_linkedin_admin_notice');

/**
 * Removes the import result args from the URL after the notice is shown.
 *
 * @param string[] $args Query args WordPress strips from admin URLs.
 * @return string[]
 */
function rickmanu_linkedin_removable_query_args(array $args): array
{
    return array_merge($args, ['rickmanu_linkedin', 'rickmanu_created', 'rickmanu_updated', 'rickmanu_skipped']);
}
add_filter('removable_query_args', 'rickmanu_linkedin_removable_query_args');

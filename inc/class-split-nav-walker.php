<?php

class Split_Nav_Walker extends Walker_Nav_Menu
{
    private int $total_items  = 0;
    private int $current_item = 0;

    public function walk($elements, $max_depth, ...$args): string
    {
        $this->total_items  = count($elements);
        $this->current_item = 0;
        return parent::walk($elements, $max_depth, ...$args);
    }

    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0): void
    {
        $this->current_item++;
        $half = (int) ceil($this->total_items / 2);

        if ($this->current_item === 1) {
            $output .= '<div class="flex">';
        } elseif ($this->current_item === $half + 1) {
            $output .= '</div><div class="flex">';
        }

        $classes   = empty($data_object->classes) ? [] : (array) $data_object->classes;
        $classes[] = 'py-16 px-8';
        $class_str = implode(' ', array_filter($classes));

        $output .= '<li class="' . esc_attr($class_str) . '">';
        $output .= '<a href="' . esc_url($data_object->url) . '" class="text-[#C9A06F] text-[18px]">';
        $output .= esc_html($data_object->title);
        $output .= '</a>';
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null): void
    {
        $output .= '</li>';
        if ($this->current_item === $this->total_items) {
            $output .= '</div>';
        }
    }
}

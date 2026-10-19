import fs from 'node:fs';
import path from 'node:path';
import { pipeline } from 'node:stream/promises';
import { fileURLToPath } from 'node:url';
import { ZipArchive } from 'archiver';

const themeDir = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const themeName = path.basename(themeDir);

async function createZip() {
    const styleCSS = fs.readFileSync(path.join(themeDir, 'style.css'), 'utf8');
    const version = styleCSS.match(/^[\s*]*Version:\s*(.+)$/m)?.[1].trim();

    if (!version || !/^\d+(?:\.\d+)*(?:-[a-zA-Z0-9.-]+)?$/.test(version)) {
        throw new Error('Could not find a valid Version in style.css');
    }

    const outputName = `${themeName}-${version}.zip`;
    const outputPath = path.join(themeDir, '..', outputName);
    const archive = new ZipArchive({ zlib: { level: 9 } });
    const output = fs.createWriteStream(outputPath);
    const completion = pipeline(archive, output);

    archive.on('warning', (error) => archive.destroy(error));
    archive.glob('**/*', {
        cwd: themeDir,
        ignore: [
            'node_modules/**',
            'package.json',
            'package-lock.json',
            'postcss.config.js',
            'scripts/**',
            'assets/src/**',
            '.git/**',
            '.github/**',
            '.vscode/**',
            '.gitignore',
            '**/.env*',
            '**/.DS_Store',
            '**/*.log',
            '**/*.map',
            '**/*.zip',
            'hot',
        ],
        dot: true,
    }, { prefix: themeName });

    await Promise.all([archive.finalize(), completion]);
    console.log(`Created: ${outputName} (${archive.pointer()} bytes)`);
}

createZip().catch((error) => {
    console.error('Theme packaging failed:', error);
    process.exitCode = 1;
});

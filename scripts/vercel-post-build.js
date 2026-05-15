import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const root = path.resolve(__dirname, '..');

// Vercel needs a folder called "dist" (or "build") at the project root.
// We keep the real output inside public/ for Laravel; this script mirrors the
// static assets into dist/ so Vercel's build check is satisfied.

fs.mkdirSync(path.join(root, 'dist'), { recursive: true });

// Mirror public/build → dist/build  (Vite-hashed JS/CSS)
if (fs.existsSync(path.join(root, 'public', 'build'))) {
    fs.cpSync(
        path.join(root, 'public', 'build'),
        path.join(root, 'dist', 'build'),
        { recursive: true }
    );
    console.log('✓ Copied public/build → dist/build');
}

// Mirror public/images → dist/images  (static images, if any)
if (fs.existsSync(path.join(root, 'public', 'images'))) {
    fs.cpSync(
        path.join(root, 'public', 'images'),
        path.join(root, 'dist', 'images'),
        { recursive: true }
    );
    console.log('✓ Copied public/images → dist/images');
}

// Drop a tiny placeholder so the dist/ root itself has at least one file
fs.writeFileSync(path.join(root, 'dist', '.vercel-static'), '');
console.log('✓ dist/ ready for Vercel');

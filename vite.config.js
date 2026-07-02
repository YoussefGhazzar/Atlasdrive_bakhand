import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";
import { fileURLToPath, URL } from "node:url";

export default defineConfig({
    server: {
        host: "0.0.0.0",
        port: 5173,
        hmr: {
            host: "localhost",
        },
    },

    plugins: [
        laravel({
            input: "resources/js/app.js",
            refresh: true,
        }),
        vue(),
    ],

    resolve: {
        alias: {
            "@": fileURLToPath(new URL("./resources/js", import.meta.url)),
            "ziggy-js": path.resolve("vendor/tightenco/ziggy"),
        },
    },
});
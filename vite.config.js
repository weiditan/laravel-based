import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js", "resources/sass/custom.scss"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            "~datatables.net-bs5": path.resolve(__dirname, "node_modules/datatables.net-bs5"),
            "~@mdi/font": path.resolve(__dirname, "node_modules/@mdi/font"),
        },
    },
});

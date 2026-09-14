/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#00236f",
        secondary: "#a53936",
        success: "#10B981",
        warning: "#F59E0B",
        danger: "#EF4444",
        background: "#f1f5f9",
        "surface-card": "#ffffff",
        "text-main": "#0f172a",
        "text-muted": "#64748b",
        border: "#e2e8f0",
      },
      fontFamily: {
        'inter': ['Inter', 'sans-serif'],
        'mono': ['JetBrains Mono', 'monospace'],
      },
    },
  },
  plugins: [],
}
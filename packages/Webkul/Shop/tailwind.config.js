/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./src/Resources/**/*.blade.php", "./src/Resources/**/*.js"],

    theme: {
        container: {
            center: true,

            screens: {
                "2xl": "1440px",
            },

            padding: {
                DEFAULT: "90px",
            },
        },

        screens: {
            sm: "525px",
            md: "768px",
            lg: "1024px",
            xl: "1240px",
            "2xl": "1440px",
            1180: "1180px",
            1060: "1060px",
            991: "991px",
            868: "868px",
        },

        extend: {
            colors: {
                navyBlue: "#060C3B",     // do not use
                lightOrange: "#F6F2EB",  // do not use
                darkGreen: '#40994A',   // do not use
                darkBlue: '#0044F2',   // do not use
                darkPink: '#F85156',    // do not use
                
                primary: '#C9A227',     // Gold
                secondary: '#1A1A1A',   // Black
                surface: '#111111',     // Cards/Navbar
                background: '#000000',  // Main background
                foreground: '#FFFFFF',  // Main text
                muted: '#B3B3B3',       // Secondary text
                border: '#333333',
                accent: '#D4AF37',
                danger: '#FF1C24',

                laahtech: '#1AAD21',    // do not use
            },

            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
                dmserif: ["DM Serif Display", "serif"],
            },
        }
    },

    plugins: [],

    safelist: [
        {
            pattern: /icon-/,
        }
    ]
};

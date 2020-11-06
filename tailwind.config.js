module.exports = {
    future: {},
    purge: {
        content: [
            './resources/views/**/*.blade.php',
        ]
    },
    theme: {
        fontFamily: {
            body: ['Muli', 'sans-serif'],
        },
        extend: {
            colors: {
                green: {
                    '100': '#D2FFE7',
                    '200': '#A3FFCE',
                    '300': '#61FFAB',
                    '400': '#19FF89',
                    '500': '#0FE77B',
                    '600': '#11CA6D',
                    '700': '#0CB862',
                    '800': '#089650',
                    '900': '#026D37',
                },
                blue: {
                    '50': '#E0EDFF',
                    '100': '#D3E5FF',
                    '200': '#A2C7FF',
                    '300': '#78AEFF',
                    '400': '#5599FF',
                    '500': '#3283FD',
                    '600': '#0368FF',
                    '700': '#035DE4',
                    '800': '#024FC3',
                    '900': '#0043A9',
                },
                yellow: {
                    '100': '#FDECC2',
                    '200': '#FFDA92',
                    '300': '#FFCE6D',
                    '400': '#FDBF3E',
                    '500': '#FDB51E',
                    '600': '#FFB002',
                    '700': '#E39E03',
                    '800': '#BE8603',
                    '900': '#926601',
                },
                red: {
                    '100': '#FDEAED',
                    '200': '#FDCED6',
                    '300': '#FD6975',
                    '400': '#FF4757',
                    '500': '#FF293B',
                    '600': '#FF1428',
                    '700': '#E70014',
                    '800': '#BC0009',
                    '900': '#98000D',
                },
                gray: {
                    '50': '#F9FAFB',
                    '100': '#F7FAFC',
                    '200': '#EDF2F7',
                    '300': '#E2E8F0',
                    '400': '#CBD5E0',
                    '500': '#A0AEC0',
                    '600': '#718096',
                    '700': '#4A5568',
                    '800': '#2D3748',
                    '900': '#1A202C',
                },
            },
            spacing: {
                '3/2': '0.875rem',
                '7': '1.75rem',
                '11': '2.75rem',
                '72': '18rem',
                '84': '21rem',
                '96': '24rem',
            },
            fontSize: {
                'md': '1.125rem',
            },
            opacity: {
                '10': '.1',
                '15': '.15',
            },
            animation: {
                'spin-fast': 'spin 500ms linear infinite',
            }
        },
        shadowOutline: {
            'shadow': '0 0 0 0.2em',
            'alpha': '0.5'
        },
        shadowOutlineColors: {
            'blue': '#A2C7FF',
        }
    },
    variants: {
        shadowOutline: ['focus'],
        /*textColor: ({after}) => after(['active']),*/
    },
    plugins: [
        require('@tailwindcss/custom-forms'),
        require('tailwindcss-shadow-outline-colors')(),
    ],
}

module.exports = {
  env: {
    es2021: true,
    browser: true,
    'jest/globals': true,
  },
  extends: [
    'airbnb-base',
    'eslint:recommended',
    'plugin:vue/essential',
    'plugin:tailwindcss/recommended',
  ],
  parserOptions: {
    ecmaVersion: 12,
    sourceType: 'module',
  },
  plugins: [
    'vue',
    'jest',
    'tailwindcss',
  ],
  globals: {
    '_': 'readonly',
    'axios': 'readonly',
    'appConfig': 'readonly',
  },
  settings: {
    'import/resolver': {
      alias: {
        map: [
          ['@', './resources/assets/admin/vue'],
        ],
        extensions: ['.vue', '.js'],
      },
    },
  },
  rules: {
    'func-names': ['error', 'never'],
    'no-param-reassign': ['error', { props: false }],
    'no-underscore-dangle': ['error', { allow: ['_uid'] }],
    'no-multi-assign': ['error', { ignoreNonDeclaration: true }],
    'max-len': [1, { code: 300, ignorePattern: '<\\s*path|symbol[^>]*>(.*?)' }],

    'jest/no-disabled-tests': 'warn',
    'jest/no-focused-tests': 'error',
    'jest/no-identical-title': 'error',
    'jest/prefer-to-have-length': 'warn',
    'jest/valid-expect': 'error',

    'import/extensions': ['error', 'always', {
      js: 'never',
      vue: 'never',
    }],
  },
};

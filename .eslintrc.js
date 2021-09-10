module.exports = {
  env: {
    es2021: true,
    browser: true,
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
    'tailwindcss',
  ],
  globals: {
    '_': 'readonly',
    'axios': 'readonly',
  },
  rules: {
    'func-names': ['error', 'never'],
    'no-param-reassign': ['error', { props: false }],
    'no-underscore-dangle': ['error', { allow: ['_uid'] }],
    'no-multi-assign': ['error', { ignoreNonDeclaration: true }],
    'max-len': [1, { code: 300, ignorePattern: '<\\s*path|symbol[^>]*>(.*?)' }],
  },
};

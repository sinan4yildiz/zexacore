const base = 'resources/assets/admin/vue';

module.exports = {
  verbose: true,
  testRegex: `${base}/tests/.*.spec.js$`,
  testEnvironment: 'jest-environment-jsdom',
  moduleNameMapper: {
    '^@/(.*)$': `<rootDir>/${base}/$1`,
  },
  moduleFileExtensions: ['js', 'json', 'vue'],
  transform: {
    '^.+\\.js$': '<rootDir>/node_modules/babel-jest',
    '.*\\.(vue)$': '<rootDir>/node_modules/vue-jest',
  },
  'setupFiles': [
    '<rootDir>/jest.setup.js',
  ],
  snapshotSerializers: ['jest-serializer-vue'],
  collectCoverage: false,
  collectCoverageFrom: [
    `/${base}/**/*.{js,vue}`,
    '!**/node_modules/**',
  ],
  coverageReporters: ['html', 'text-summary'],
  coverageDirectory: './coverage',
};

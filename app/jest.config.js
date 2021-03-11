module.exports = {
    testRegex: __dirname + '/Modules/Layout/Resources/assets/js/test/.*.spec.js$',
    moduleFileExtensions: [
        'js',
        'json',
        'vue'
    ],
    'transform': {
        '^.+\\.js$': '<rootDir>/node_modules/babel-jest',
        '.*\\.(vue)$': '<rootDir>/node_modules/vue-jest'
    },
    setupFiles: [
        __dirname + '/Modules/Layout/Resources/assets/js/test/setup.js',
    ],
}

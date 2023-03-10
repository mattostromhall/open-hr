module.exports = {
    'env': {
        'browser': true,
        'es2021': true,
        'vue/setup-compiler-macros': true
    },
    'extends': [
        'eslint:recommended',
        'plugin:vue/vue3-recommended',
        'plugin:tailwindcss/recommended',
        'plugin:@typescript-eslint/recommended'
    ],
    'overrides': [{
        'files': [
            '.eslintrc.js',
        ],
        'env': {
            'node': true,
            'browser': false,
        },
    }],
    'parser': 'vue-eslint-parser',
    'parserOptions': {
        'ecmaVersion': 'latest',
        'parser': '@typescript-eslint/parser',
        'sourceType': 'module'
    },
    'plugins': [
        'vue',
        '@typescript-eslint'
    ],
    'rules': {
        'indent': [
            'error',
            4
        ],
        'linebreak-style': [
            'error',
            'unix'
        ],
        'quotes': [
            'error',
            'single'
        ],
        'semi': [
            'error',
            'never'
        ],
        'vue/html-indent': [
            'error',
            4
        ],
        'vue/multi-word-component-names': 'off',
        'tailwindcss/no-custom-classname': 'off'
    }
}

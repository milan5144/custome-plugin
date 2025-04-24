module.exports = {
    plugins:{
        'postcss-import': {},
        'postcss-custom-media': {},
        'postcss-nested':{},
        'postcss-preset-env': {},
        'autoprefixer': {},
        'cssnano':{
            preset: ['default', {
                autoprefixer: false,
            }]
        }
    }
};
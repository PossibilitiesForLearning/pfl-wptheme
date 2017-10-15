module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        compass: {
            dist: {
                options: {
                    sassDir: 'src/scss',
                    cssDir: 'wp-content/themes/transoft',
                    environment: 'production',
                    noLineComments: false
                }
            }
        },
        
        watch: {
            compass: {
                files: 'src/scss/**/*.scss',
                tasks: ['compass']
            },
            scripts: {
                files: 'src/js/**/*.js', 
                tasks: ['uglify']
            }
        },

        uglify: {
            options: {
                mangle: false
            },
            js_compile: {
                files: {
                    'wp-content/themes/transoft/js/global.min.js': ['src/js/global/_*.js']
                }
            },
            transfer: {
                files: [{
                    expand: true,
                    cwd: 'src/js/page',
                    src: '**/*.js',
                    dest: 'wp-content/themes/transoft/js/page'
                }]
            },
            component: {
            	mangle: true,
                files: [{
                    expand: true,
                    cwd: 'src/js/component',
                    src: '**/*.js',
                    dest: 'wp-content/themes/transoft/js/component'
                }]
            }
        },        
    });    
    
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('default', ['watch']);
}

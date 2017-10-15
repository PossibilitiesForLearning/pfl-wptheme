module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        compass: {
            dist: {
                options: {
                    sassDir: 'src/scss',
                    cssDir: 'wp-content/themes/pfl',
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
                mangle: true,
                beautify: false
            },
            js_compile: {
                files: {
                    'wp-content/themes/pfl/js/scripts.min.js': ['src/js/_*.js']
                }
            }
        },            
    });    
    
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('default', ['watch']);
}

module.exports = function(grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        makepot: {
            target: {
                options: {
                    domainPath: '/languages',
                    potFilename: 'bs-wib.pot',
                    type: 'wp-plugin'
                }
            }
        }
    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-wp-i18n');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['makepot']);

};
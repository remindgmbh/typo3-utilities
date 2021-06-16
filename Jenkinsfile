#!/usr/bin/env groovy

pipeline {

    agent any

    stages {

        stage('Clean') {

            steps {
                sh 'rm -rf ./.build/bin'
                sh 'rm -rf ./.build/logs'
                sh 'rm -rf ./.build/vendor'
                sh 'rm -rf ./.build/web'

                sh 'mkdir ./.build/logs'
            }
        }

        stage('Build') {

            steps {
                sh '/usr/bin/wget https://getcomposer.org/composer.phar --quiet'
                sh '/usr/bin/php7.4 ./composer.phar update --no-progress --quiet --no-interaction'
            }
        }

        stage('Analyze and Document') {

            parallel {

                stage('Analyze') {

                    steps {
                        sh '/usr/bin/php7.4 ./composer.phar run pmd'
                        sh(returnStatus: true, script:'/usr/bin/php7.4 ./composer.phar run phpcpd')
                        sh '/usr/bin/php7.4 ./composer.phar run test'
                    }
                }

                stage('Confluence Changelog') {

                    steps {

                        withCredentials([string(credentialsId: 'confluence-rest-api-token-hschulz', variable: 'TOKEN')]) {
                            sh(returnStatus: true, script: '/usr/bin/php7.4 ./composer.phar run conflog -- --token ${TOKEN}')
                        }
                    }
                }
            }
        }
    }

    post {

        always {
            recordIssues enabledForFailure: true, tool: pmdParser(pattern: '**/.build/logs/pmd.xml')
            recordIssues enabledForFailure: true, tool: cpd(pattern: '**/.build/logs/pmd-cpd.xml')

            junit '**/.build/logs/unitreport.xml'
        }

        success {
            slackSend(color: 'good', message: "${env.JOB_NAME} - #${env.BUILD_NUMBER} Success (<${env.BUILD_URL}|Open>)")
        }

        failure {
            slackSend(color: 'danger', message: "${env.JOB_NAME} - #${env.BUILD_NUMBER} Failure (<${env.BUILD_URL}|Open>)")
        }
    }
}

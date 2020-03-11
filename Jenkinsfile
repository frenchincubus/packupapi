pipeline {
    agent any
    stages {
        stage('DeleteDockers') {
            steps {
                sh 'docker rm -f $(docker ps -a -q)'
            }
        }
        stage('Build') {
            steps {
                sh 'docker-compose up -d'
            }
        }
        stage('Composer') {
            steps {
                sh 'docker exec php composer install'
            }
        }
        stage('migration') {
            steps {
                sh 'docker exec php php bin/console make:migration'
            }
        }
        stage('migrate') {
            steps {
                sh 'docker exec php php bin/console doctrine:migrations:migrate'
            }
        }
        stage('Install public') {
            steps {
                sh 'docker exec php php bin/console assets:install -- public'
            }
        }
        stage('Doctrine fixtures') {
            steps {
                sh 'docker exec php php bin/console doctrine:fixtures:load'
            }
        }
    }
}
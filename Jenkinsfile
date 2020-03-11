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
         stage('delete cache') {
            steps {
                sh 'docker exec php php bin/console cache:clear '
            }
        }
        stage('Composer') {
            steps {
                sh 'docker exec php composer install'
            }
        }
        stage('Install public') {
            steps {
                sh 'docker exec php php bin/console assets:install -- public'
            }
        }
    }
}
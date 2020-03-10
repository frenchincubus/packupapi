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
           stage('Php Image') {
            steps {
                sh 'docker exec -it php bash'
            }
        }
                   stage('Composer') {
            steps {
                sh 'composer install'
            }
        }
                   stage('Install public') {
            steps {
                sh 'php bin/console assets:install -- public'
            }
        }
                       stage('DataFixtures ') {
            steps {
                sh 'php bin/console doctrine:fixtures:load'
            }
        }
    }
}
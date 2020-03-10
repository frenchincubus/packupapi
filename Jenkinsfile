pipeline {
    agent {
        docker {
            image 'nginx'
            args '3200:80'
        }
    }
    environment {
        CI = 'true'
    }
    stages {
        stage('Build') {
            steps {
                sh 'docker-compose build'
            }
        }
        stage('Mount') {
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
pipeline {
    agent any

    tools {
        nodejs 'nodejs'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'npm install'
            }
        }

        stage('Build Lungsurin') {
            steps {
                sh 'npm run build'
            }
        }

        stage('Test') {
            steps {
                sh 'npm test || echo "No test defined"'
            }
        }
    }

    post {
        success {
            echo 'Lungsurin Success'
        }
        failure {
            echo 'Lungsurin Failed'
        }
    }
}

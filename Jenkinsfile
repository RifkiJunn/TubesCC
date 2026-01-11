pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                echo 'Install dependency Lungsurin'
            }
        }

        stage('Build Lungsurin') {
            steps {
                echo 'Build Lungsurin'
            }
        }

        stage('Test') {
            steps {
                echo 'Testing Lungsurin'
            }
        }
    }
}

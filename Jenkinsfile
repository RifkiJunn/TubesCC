pipeline {
    agent any
    options {
        skipDefaultCheckout(true)
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                echo 'Simulasi install dependency Lungsurin'
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

    post {
        success {
            echo 'Success'
        }
        failure {
            echo 'Failed'
        }
    }
}


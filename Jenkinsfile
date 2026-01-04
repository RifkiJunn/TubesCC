pipeline {
    agent any
    
    environment {
        AZURE_APP_NAME = 'tubescc-lungsur-app'
        AZURE_RESOURCE_GROUP = 'TubesCloud'
    }
    
    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }
        
        stage('Install Dependencies') {
            steps {
                sh '''
                    # Install Composer dependencies
                    composer install --no-dev --optimize-autoloader
                    
                    # Install Node dependencies
                    npm ci
                '''
            }
        }
        
        stage('Build Assets') {
            steps {
                sh 'npm run build'
            }
        }
        
        stage('Prepare Deployment') {
            steps {
                sh '''
                    # Create deployment package
                    mkdir -p deployment
                    rsync -av --exclude='node_modules' --exclude='.git' --exclude='tests' \
                          --exclude='storage/logs/*' --exclude='storage/framework/cache/*' \
                          --exclude='storage/framework/sessions/*' --exclude='storage/framework/views/*' \
                          . deployment/
                '''
            }
        }
        
        stage('Deploy to Azure') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'azure-webapp-deploy', usernameVariable: 'AZURE_USER', passwordVariable: 'AZURE_PASS')]) {
                    sh '''
                        # Create deployment package
                        cd deployment
                        zip -r ../deploy.zip .
                        cd ..
                        
                        # Deploy using Zip Deploy API
                        curl -X POST \
                            -u $AZURE_USER:$AZURE_PASS \
                            --data-binary @deploy.zip \
                            https://tubescc-lungsur-app.scm.azurewebsites.net/api/zipdeploy
                    '''
                }
            }
        }
        
        stage('Run Migrations') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'azure-webapp-deploy', usernameVariable: 'AZURE_USER', passwordVariable: 'AZURE_PASS')]) {
                    sh '''
                        # Run migrations using Kudu API
                        curl -X POST \
                            -u $AZURE_USER:$AZURE_PASS \
                            -H "Content-Type: application/json" \
                            -d '{"command":"cd /home/site/wwwroot && php artisan migrate --force && php artisan config:cache","dir":"/home/site/wwwroot"}' \
                            https://tubescc-lungsur-app.scm.azurewebsites.net/api/command
                    '''
                }
            }
        }
    }
    
    post {
        always {
            cleanWs()
        }
        success {
            echo 'Deployment successful!'
        }
        failure {
            echo 'Deployment failed!'
        }
    }
}

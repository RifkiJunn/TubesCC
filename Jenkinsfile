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
                withCredentials([azureServicePrincipal('azure-credentials')]) {
                    sh '''
                        # Login to Azure
                        az login --service-principal -u $AZURE_CLIENT_ID -p $AZURE_CLIENT_SECRET --tenant $AZURE_TENANT_ID
                        
                        # Deploy to Web App
                        cd deployment
                        zip -r ../deploy.zip .
                        cd ..
                        
                        az webapp deployment source config-zip \
                            --resource-group $AZURE_RESOURCE_GROUP \
                            --name $AZURE_APP_NAME \
                            --src deploy.zip
                    '''
                }
            }
        }
        
        stage('Run Migrations') {
            steps {
                sh '''
                    # Run migrations on Azure Web App
                    az webapp ssh --resource-group $AZURE_RESOURCE_GROUP --name $AZURE_APP_NAME --command "php artisan migrate --force"
                '''
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

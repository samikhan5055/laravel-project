
pipeline {
    agent any

    environment {
        DEPLOY_DIR = '/var/www/student-management'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build') {
            steps {
                sh '''
                    set -eu
                    composer install --no-interaction --prefer-dist --optimize-autoloader

                    if [ ! -f .env ]; then
                        cp .env.example .env
                    fi

                    mkdir -p database
                    touch database/database.sqlite

                    export DB_CONNECTION=sqlite
                    export DB_DATABASE="$WORKSPACE/database/database.sqlite"
                    export SESSION_DRIVER=file
                    export CACHE_STORE=file
                    export QUEUE_CONNECTION=sync

                    if ! grep -q '^APP_KEY=base64:' .env; then
                        php artisan key:generate --force
                    fi

                    php artisan config:clear
                '''
            }
        }

        stage('Test') {
            steps {
                sh '''
                    set -eu
                    export DB_CONNECTION=sqlite
                    export DB_DATABASE="$WORKSPACE/database/database.sqlite"
                    export SESSION_DRIVER=file
                    export CACHE_STORE=file
                    export QUEUE_CONNECTION=sync

                    php artisan migrate --force
                    php artisan test
                '''
            }
        }

        stage('Deploy to EC2') {
            steps {
                sh '''
                    set -eu

                    test -f "$DEPLOY_DIR/.env"
                    test -d "$DEPLOY_DIR/storage"
                    test -d "$DEPLOY_DIR/bootstrap/cache"

                    rsync -a --delete \
                        --exclude='/.env' \
                        --exclude='/storage/' \
                        --exclude='/bootstrap/cache/' \
                        --exclude='/.git/' \
                        --exclude='/database/database.sqlite' \
                        "$WORKSPACE/" "$DEPLOY_DIR/"

                    cd "$DEPLOY_DIR"

                    php artisan optimize:clear
                    php artisan config:cache
                    php artisan route:cache
                    php artisan view:cache

                    echo "Deployment files updated successfully."
                '''
            }
        }
    }

    post {
        success {
            echo 'Build, tests, and deployment completed successfully.'
        }

        failure {
            echo 'Pipeline failed. Check the stage console output.'
        }

        always {
            echo 'Pipeline execution finished.'
        }
    }
}


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

                    echo "Installing Composer dependencies..."
                    composer install \
                        --no-interaction \
                        --prefer-dist \
                        --optimize-autoloader

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

                    echo "Build completed."
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

                    echo "Preparing test database..."
                    php artisan migrate --force

                    echo "Running Laravel tests..."
                    php artisan test

                    echo "All tests passed."
                '''
            }
        }

        stage('Deploy to EC2') {
            steps {
                sh '''
                    set -eu

                    echo "Checking deployment directory..."
                    test -f "$DEPLOY_DIR/.env"
                    test -d "$DEPLOY_DIR/storage"
                    test -d "$DEPLOY_DIR/bootstrap/cache"

                    echo "Copying application files..."

                    rsync -rlpt \
                        --no-owner \
                        --no-group \
                        --delete \
                        --exclude='/.env' \
                        --exclude='/storage/' \
                        --exclude='/bootstrap/cache/' \
                        --exclude='/.git/' \
                        --exclude='/database/database.sqlite' \
                        "$WORKSPACE/" "$DEPLOY_DIR/"

                    cd "$DEPLOY_DIR"

                    echo "Clearing old Laravel caches..."
                    php artisan optimize:clear

                    echo "Building production configuration cache..."
                    php artisan config:cache
                    php artisan route:cache
                    php artisan view:cache

                    echo "Checking deployed Laravel application..."
                    php artisan --version
                    php artisan route:list --path=students

                    echo "Deployment completed successfully."
                '''
            }
        }
    }

    post {
        success {
            echo 'SUCCESS: Build, tests, and EC2 deployment completed.'
        }

        failure {
            echo 'FAILURE: Check the Console Output for the failed stage.'
        }

        always {
            echo 'Pipeline execution finished.'
        }
    }
}


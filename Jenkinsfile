pipeline {
    agent any

    environment {
        PATH = '/usr/bin:/bin'
        APP_URL = 'http://127.0.0.1:8001'
    }

    stages {

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Check Environment') {
            steps {
                sh '''
                    set -eu

                    echo "Checking PHP..."
                    php -v

                    echo "Checking Composer..."
                    composer --version

                    echo "Checking project files..."
                    test -f artisan
                    test -f composer.json

                    echo "Environment check completed."
                '''
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

                    echo "Preparing environment file..."
                    if [ ! -f .env ]; then
                        cp .env.example .env
                    fi

                    echo "Preparing SQLite database..."
                    mkdir -p database
                    touch database/database.sqlite
                '''
            }
        }

        stage('Configure Laravel') {
            steps {
                sh '''
                    set -eu

                    export DB_CONNECTION=sqlite
                    export DB_DATABASE="$WORKSPACE/database/database.sqlite"
                    export SESSION_DRIVER=file
                    export CACHE_STORE=file
                    export QUEUE_CONNECTION=sync

                    echo "Generating application key if required..."

                    if ! grep -q '^APP_KEY=base64:' .env; then
                        php artisan key:generate --force
                    fi

                    echo "Clearing Laravel configuration cache..."
                    php artisan config:clear

                    echo "Running database migrations..."
                    php artisan migrate --force

                    echo "Laravel configuration completed."
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

                    echo "Running Laravel tests..."
                    php artisan test

                    echo "All tests passed."
                '''
            }
        }

        stage('Deploy Locally') {
            steps {
                sh '''
                    set -eu

                    export DB_CONNECTION=sqlite
                    export DB_DATABASE="$WORKSPACE/database/database.sqlite"
                    export SESSION_DRIVER=file
                    export CACHE_STORE=file
                    export QUEUE_CONNECTION=sync

                    echo "Preparing Laravel for deployment..."

                    php artisan config:clear
                    php artisan route:clear
                    php artisan view:clear

                    echo "Stopping the previous application server if it is running..."

                    if [ -f "$WORKSPACE/laravel-server.pid" ]; then
                        OLD_PID=$(cat "$WORKSPACE/laravel-server.pid")

                        if kill -0 "$OLD_PID" 2>/dev/null; then
                            kill "$OLD_PID" 2>/dev/null || true
                        fi

                        rm -f "$WORKSPACE/laravel-server.pid"
                    fi

                    echo "Starting Laravel server..."

                    nohup setsid php artisan serve \
                        --host=127.0.0.1 \
                        --port=8001 \
                        > "$WORKSPACE/laravel-server.log" 2>&1 < /dev/null &

                    SERVER_PID=$!
                    echo "$SERVER_PID" > "$WORKSPACE/laravel-server.pid"

                    echo "Waiting for the application to become available..."

                    ATTEMPTS=0

                    until curl --silent --show-error --fail \
                        "$APP_URL" \
                        --output /dev/null
                    do
                        ATTEMPTS=$((ATTEMPTS + 1))

                        if [ "$ATTEMPTS" -ge 20 ]; then
                            echo "ERROR: Laravel application did not become available."
                            echo "Server log:"
                            cat "$WORKSPACE/laravel-server.log"
                            exit 1
                        fi

                        sleep 2
                    done

                    echo "Deployment successful!"
                    echo "Application URL: $APP_URL"
                    echo "Server PID: $SERVER_PID"
                '''
            }
        }
    }

    post {
        success {
            echo 'CI/CD pipeline completed successfully.'
            echo 'Laravel application: http://127.0.0.1:8001'
        }

        failure {
            echo 'CI/CD pipeline failed. Check the stage logs for details.'
        }

        always {
            echo 'Pipeline execution finished.'
        }
    }
}

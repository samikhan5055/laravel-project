pipeline {
    agent any

    options {
        timestamps()
        disableConcurrentBuilds()
    }

    environment {
        APP_PORT = '8001'
        PATH = '/usr/bin:/bin'
    }

    stages {
        stage('Checkout') {
            steps {
                echo 'Getting Laravel source code from GitHub'
                checkout scm
            }
        }

        stage('Build') {
            steps {
                echo 'Checking PHP and Composer'

                sh '''
                    set -eu

                    php -v
                    composer --version

                    test -f composer.json
                    test -f artisan

                    if [ ! -f .env ]; then
                        cp .env.example .env
                    fi

                    mkdir -p database storage/logs
                    touch database/database.sqlite

                    composer install \
                        --no-interaction \
                        --prefer-dist
                '''
            }
        }

        stage('Configure Laravel') {
            steps {
                sh '''
                    set -eu

                    export DB_CONNECTION=sqlite
                    export DB_DATABASE="$WORKSPACE/database/database.sqlite"

                    if ! grep -q '^APP_KEY=base64:' .env; then
                        php artisan key:generate --force
                    fi

                    php artisan config:clear
                '''
            }
        }

        stage('Test') {
            steps {
                echo 'Running Laravel tests'

                sh '''
                    set -eu

                    export DB_CONNECTION=sqlite
                    export DB_DATABASE="$WORKSPACE/database/database.sqlite"

                    php artisan test
                '''
            }
        }

        stage('Deploy Locally') {
            steps {
                sh '''
                    set -eu

                    export DB_CONNECTION=sqlite
                    export DB_DATABASE="$WORKSPACE/database/database.sqlite"

                    if [ -f .laravel-server.pid ]; then
                        old_pid=$(cat .laravel-server.pid)

                        if kill -0 "$old_pid" 2>/dev/null; then
                            kill "$old_pid" || true
                        fi

                        rm -f .laravel-server.pid
                    fi

                    nohup php artisan serve \
                        --host=127.0.0.1 \
                        --port="$APP_PORT" \
                        > storage/logs/jenkins-server.log 2>&1 &

                    echo $! > .laravel-server.pid

                    for attempt in $(seq 1 20); do
                        if curl --fail --silent \
                            "http://127.0.0.1:$APP_PORT/" \
                            -o /dev/null; then
                            echo "Laravel is responding successfully."
                            exit 0
                        fi

                        sleep 2
                    done

                    echo "Deployment verification failed."
                    tail -50 storage/logs/jenkins-server.log
                    exit 1
                '''
            }
        }
    }

    post {
        success {
            echo 'CI/CD pipeline completed successfully.'
            echo 'Application URL: http://localhost:8001'
        }

        failure {
            echo 'Pipeline failed. Check the Console Output.'
        }
    }
}

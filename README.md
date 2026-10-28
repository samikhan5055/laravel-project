# Laravel Project — DevOps & Cloud Deployment

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker" />
  <img src="https://img.shields.io/badge/Docker_Compose-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker Compose" />
  <img src="https://img.shields.io/badge/Docker_Hub-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker Hub" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Jenkins-D24939?style=for-the-badge&logo=jenkins&logoColor=white" alt="Jenkins" />
  <img src="https://img.shields.io/badge/Amazon_AWS-232F3E?style=for-the-badge&logo=amazonwebservices&logoColor=FF9900" alt="Amazon AWS" />
  <img src="https://img.shields.io/badge/Kubernetes-326CE5?style=for-the-badge&logo=kubernetes&logoColor=white" alt="Kubernetes" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Linux-FCC624?style=for-the-badge&logo=linux&logoColor=black" alt="Linux" />
  <img src="https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white" alt="Git" />
  <img src="https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub" />
</p>

<p align="center">
  <strong>Containerization • CI/CD • Cloud Deployment • DevOps Automation</strong>
</p>

<p align="center">
  <a href="https://github.com/samikhan5055/laravel-project">Repository</a> ·
  <a href="https://laravel.com/docs">Laravel Docs</a> ·
  <a href="https://docs.docker.com/">Docker Docs</a> ·
  <a href="https://kubernetes.io/docs/">Kubernetes Docs</a>
</p>

---


---

## Overview

This project combines Laravel application development with practical DevOps tools and deployment workflows. It provides a foundation for learning how to package a web application into Docker containers, manage services with Docker Compose, build and test application code, and prepare deployments on cloud infrastructure.

The project is also a practical learning resource for understanding how development and deployment processes work together.

## Key Objectives

- Develop and run a Laravel web application.
- Package the application into a Docker image.
- Manage application and database services using Docker Compose.
- Store and distribute container images through Docker Hub.
- Configure a Jenkins pipeline for build and test automation.
- Explore deployment on AWS EC2.
- Practice Kubernetes concepts and application deployment.

> **Note:** The objectives above describe the project's DevOps scope. Individual integrations and deployment steps depend on the configuration present in the repository and the environment where the project is running.

## Technology Stack

| Technology | Purpose |
|---|---|
| Laravel | Web application framework |
| PHP | Backend programming language |
| Composer | PHP dependency management |
| MySQL | Relational database |
| Docker | Application containerization |
| Docker Compose | Multi-container application management |
| Docker Hub | Container image registry |
| Git & GitHub | Version control and source code hosting |
| Jenkins | Build and test automation |
| AWS EC2 | Cloud virtual machine for deployment |
| Kubernetes | Container orchestration and deployment practice |

## Architecture

The intended containerized application structure is:

```text
                 Developer
                     |
                     v
                GitHub Repo
                     |
                     v
              Jenkins Pipeline
                     |
              Build and Test
                     |
                     v
                Docker Image
                     |
                     v
                 Docker Hub
                     |
                     v
                 AWS EC2
                     |
                     v
              Docker Compose
                 /       \
                v         v
          Laravel App    MySQL
```

This diagram illustrates the intended workflow. Jenkins, Docker Hub, and AWS integration must be configured before the complete automated workflow can run.

## Prerequisites

Install the following tools before starting:

- Git
- PHP compatible with the Laravel project
- Composer
- Docker Engine
- Docker Compose plugin
- A MySQL database, or use the database container provided by the Compose configuration

For cloud deployment, you will also need an AWS account and an EC2 instance with the required security configuration.

## Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/samikhan5055/laravel-project.git
cd laravel-project
```

### 2. Configure environment variables

For a standard Laravel installation, create your local environment file:

```bash
cp .env.example .env
```

Edit `.env` and configure your application and database settings.

For example:

```dotenv
APP_NAME=LaravelProject
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=CHANGE_ME
```

Adjust the values to match your database configuration. When running inside Docker Compose, the database host is normally the database service name, such as `db`, rather than `127.0.0.1`.

**Security:** Never commit `.env` files, passwords, API keys, or other secrets to GitHub.

### 3. Install PHP dependencies

If PHP and Composer are installed locally:

```bash
composer install
```

### 4. Generate the application key

```bash
php artisan key:generate
```

### 5. Run database migrations

After configuring and starting your database:

```bash
php artisan migrate
```

### 6. Start the development server

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Open the following address in your browser:

**http://localhost:8000**

The commands above describe the standard Laravel workflow. If your Docker image handles dependency installation and application startup internally, use the Docker workflow below instead.

## Docker Deployment

Docker packages the application and its runtime dependencies into a portable image.

### Build the Docker image

Run this command from the project directory containing your `Dockerfile`:

```bash
sudo docker build -t laravel-project:latest .
```

### Run the application container

```bash
sudo docker run -d \
  --name laravel-app \
  -p 8000:8000 \
  laravel-project:latest
```

This assumes the image starts a web server that listens on port `8000`. The container also needs the correct environment configuration and access to its database.

### Verify the container

```bash
sudo docker ps
sudo docker logs laravel-app
```

### Stop the container

```bash
sudo docker stop laravel-app
sudo docker rm laravel-app
```

## Docker Compose

Docker Compose lets you define and manage the Laravel application and its database together.

If the repository contains `compose.yaml`, run:

```bash
sudo docker compose config
sudo docker compose up -d --build
```

Check the running services:

```bash
sudo docker compose ps
```

View application logs:

```bash
sudo docker compose logs -f app
```

View database logs:

```bash
sudo docker compose logs -f db
```

Stop the services:

```bash
sudo docker compose down
```

The actual service names and required environment variables must match your `compose.yaml` file. Avoid deleting database volumes unless you intentionally want to remove their stored data.

## Docker Hub

Docker Hub can be used to publish the application's container image.

### 1. Log in

```bash
sudo docker login
```

### 2. Tag the image

Replace `YOUR_DOCKERHUB_USERNAME` with your Docker Hub username:

```bash
sudo docker tag laravel-project:latest \
  YOUR_DOCKERHUB_USERNAME/laravel-project:latest
```

### 3. Push the image

```bash
sudo docker push YOUR_DOCKERHUB_USERNAME/laravel-project:latest
```

### 4. Pull the image on another machine

```bash
sudo docker pull YOUR_DOCKERHUB_USERNAME/laravel-project:latest
```

Use a versioned tag for releases so that deployments can identify the exact image being used.

## Jenkins CI/CD

Jenkins can automate repetitive development tasks through a pipeline defined in a `Jenkinsfile`.

A typical pipeline can include:

1. **Source checkout** — retrieve the application from GitHub.
2. **Dependency installation** — install required PHP packages.
3. **Build** — build the Docker image.
4. **Testing** — execute Laravel's automated tests.
5. **Image publishing** — push the image to Docker Hub.
6. **Deployment** — deploy the approved image to the target server.

Run Laravel tests in an environment with the required dependencies:

```bash
php artisan test
```

To inspect Jenkins execution, open your Jenkins dashboard and review the relevant job's build history and console output.

Automated publishing and deployment require a configured Jenkinsfile, credentials, and deployment environment.

## AWS EC2 Deployment

AWS EC2 provides a virtual server where the application can run independently of your local development machine.

A typical deployment process is:

1. Launch an EC2 instance with a supported Linux operating system.
2. Configure SSH access and install Docker.
3. Allow the required inbound traffic in the EC2 security group.
4. Pull the application image or clone the repository.
5. Configure environment variables securely.
6. Start the application using Docker or Docker Compose.
7. Test the application using the instance's public IP address or configured domain.

For example, if the application is listening on port `8000`, the address would follow this pattern:

```text
http://YOUR_EC2_PUBLIC_IP:8000
```

Replace the placeholder with the instance's actual public IP. For production, use HTTPS, restrict administrative access, and avoid exposing the database port publicly.

## Kubernetes Deployment

Kubernetes can be used to manage containerized applications through declarative configuration.

Topics to explore include:

- Deployments and replicas
- Pods and container lifecycle
- Services and network access
- ConfigMaps and Secrets
- Rolling updates and rollbacks
- Resource requests and limits
- Health checks and application availability

Useful commands for inspecting a Kubernetes deployment include:

```bash
kubectl get nodes
kubectl get pods
kubectl get deployments
kubectl get services
kubectl describe deployment DEPLOYMENT_NAME
kubectl logs POD_NAME
```

Replace the example names with the actual resources in your cluster.

Kubernetes manifests and a working cluster are required before these commands can manage this application.

## Testing and Troubleshooting

### Check Docker services

```bash
sudo docker ps -a
sudo docker compose ps
sudo docker compose logs
```

### Check Laravel configuration

```bash
php artisan about
php artisan config:clear
php artisan route:list
```

Run Artisan commands in the environment where PHP and the application's dependencies are installed.

### Common issues

| Problem | Suggested action |
|---|---|
| Application key missing | Generate `APP_KEY` using `php artisan key:generate` |
| Database connection refused | Verify database credentials, hostname, port, and service health |
| Container exits immediately | Inspect logs using `sudo docker compose logs` |
| Port already in use | Check existing processes and change the host port if necessary |
| Image push fails | Check Docker Hub authentication, image tag, and repository permissions |
| Kubernetes pod is not ready | Inspect pod events, logs, image availability, and resource limits |

## Project Structure

A typical Laravel application contains directories similar to these:

```text
laravel-project/
├── app/                # Application logic
├── bootstrap/          # Framework bootstrap files
├── config/             # Application configuration
├── database/           # Migrations, factories, and seeders
├── public/             # Public entry point and assets
├── resources/           # Views and frontend resources
├── routes/             # Application routes
├── storage/            # Logs and generated files
├── tests/              # Automated tests
├── Dockerfile          # Docker image definition, if present
├── compose.yaml        # Docker Compose configuration, if present
├── Jenkinsfile         # Jenkins pipeline, if present
└── README.md           # Project documentation
```

The listed DevOps files are conditional; retain only the entries that exist in your repository.

## Learning Outcomes

This project supports practical learning in:

- Laravel application development
- Linux command-line operations
- Git and GitHub workflows
- Docker image creation and container management
- Multi-container orchestration using Docker Compose
- CI/CD concepts with Jenkins
- Cloud deployment with AWS EC2
- Kubernetes resource management and troubleshooting

## Future Improvements

- Add automated tests to the CI pipeline.
- Introduce versioned Docker image releases.
- Configure secure environment-specific deployments.
- Add application health checks and monitoring.
- Deploy the application using Kubernetes manifests.
- Configure a domain name and HTTPS.
- Document recovery, backup, and rollback procedures.

## Contributing

Contributions, suggestions, and improvements are welcome.

1. Fork the repository.
2. Create a feature branch.
3. Make your changes.
4. Test your changes.
5. Open a pull request with a clear description.


## Author

**Sami Khan**

- GitHub: [@samikhan5055](https://github.com/samikhan5055)
- Project Repository: [laravel-project](https://github.com/samikhan5055/laravel-project)

---

<p align="center">
  <strong>Built to learn, containerize, automate, and deploy.</strong>
</p>

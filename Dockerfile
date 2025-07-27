# Stage 1: Build React app with Node
FROM node:20 AS react-builder
WORKDIR /app
COPY react-frontend/ ./react-frontend/
WORKDIR /app/react-frontend
RUN npm install && npm run build

# Stage 2: PHP Apache server, serve both PHP and built JS
FROM php:8.2-apache
# Enable mod_rewrite (optional, good for single page apps)
RUN a2enmod rewrite

# Copy PHP files
COPY public/ /var/www/html/
# Copy built React files from Stage 1
COPY --from=react-builder /app/react-frontend/../public/dist /var/www/html/dist

EXPOSE 80

FROM node:20 AS react-builder
WORKDIR /app
COPY react-frontend/ ./react-frontend/
WORKDIR /app/react-frontend
RUN npm install && npm run build

FROM php:8.2-apache

COPY public/ /var/www/html/
COPY --from=react-builder /app/react-frontend/../public/dist /var/www/html/dist

EXPOSE 80

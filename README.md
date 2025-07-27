# React + PHP Strangulation Example

This project shows how to use **React** components (built as Web Components) inside legacy **PHP** pages with **two-way data binding** between PHP and React for legacy frontend strangulation.

## Features

- React components exported as custom web components (`<hello-widget>`)
- Two-way input binding: PHP <--> React
- Scalable pattern for multiple React web components
- Simple PHP + Apache + built React served via Docker

---

## Local Development

```bash
docker-compose up --build
```

## Usage Example
  
The page public/hello.php demonstrates:

- Updating React component input from PHP
- Updating PHP field from inside the React component
- Custom events for communication

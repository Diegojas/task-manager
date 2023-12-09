# Vue.js Task Management App

This project is a web-based task management dashboard built with Vue.js. The application allows users to create, view, update, and delete tasks.

## Project Setup

To get the project up and running on your local development machine, follow these instructions.

### Prerequisites

- Node.js (https://nodejs.org/)
- Yarn package manager (https://yarnpkg.com/) or npm (https://www.npmjs.com/)

### Clone the repository

```bash
git clone https://github.com/Diegojas/task-manager.git
cd task-manager
```

### Configuration

Before starting the application, you will need to set up your environment variables.

1. Create a `.env` file from the `.env.example` provided in the vue project:

```bash
cp .env.example .env
```

2. Set `VITE_API_BASE_URL` in your `.env` file to point to the base URL of your backend API.

```env
VITE_API_BASE_URL=http://localhost:8000/api
```

### Installation

1. Install dependencies

```bash
yarn install
# or if you are using npm
npm install
```

2. Serve with hot reload at localhost:3000

```bash
yarn dev
# or if you are using npm
npm run dev
```

3. Compile and minify for production

```bash
yarn build
# or if you are using npm
npm run build
```

## Features

- Create, Read, Update, Delete tasks
- Task status management
- Responsive layout suitable for various screen sizes
- User Authentication (Register, Login, Logout)

## Built With

- Vue.js - The Progressive JavaScript Framework.
- Pinia - State management pattern + library for Vue.js applications.
- Vue Router - The official router for Vue.js.
- Tailwind CSS - A utility-first CSS framework for rapidly building custom designs.
- Axios - Promise based HTTP client for the browser and node.js
- Vite - Frontend Tooling.

## Contribution

If you would like to contribute to this project, please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a pull request

## License

This project is open source and available under the [MIT License](LICENSE).
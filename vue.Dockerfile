# Vue.js Dockerfile
FROM node:18

WORKDIR /app

# Copy root-level package.json and package-lock.json (where it actually is)
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy only the Vue app code from resources/js
COPY resources/js/ ./resources/js/

# Expose Vite's dev server port
EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host"]

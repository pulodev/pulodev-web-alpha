module.exports = {
    ci: {
      collect: {
        url: ['http://localhost:8000/'],
        startServerCommand: 'php artisan serve',
      },
      upload: {
        target: 'temporary-public-storage',
      },
    },
  };
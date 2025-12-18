FROM php:8.2-cli

WORKDIR /app
COPY . .

ENV PORT=10000
EXPOSE 10000

# Use a router so "/" works and we can add /healthz.
CMD ["sh", "-lc", "php -S 0.0.0.0:${PORT} -t . router.php"]


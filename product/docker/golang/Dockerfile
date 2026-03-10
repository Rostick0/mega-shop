FROM golang:1.26.1-alpine AS builder

WORKDIR /var/www/html

COPY go.mod go.sum ./
RUN go mod download

COPY . .

# Собираем два бинарника: приложение и миграции
RUN go build -v -o /usr/local/bin/app     ./cmd/api
RUN go build -v -o /usr/local/bin/migrate ./migrations

# ─── Runtime ──────────────────────────────────────────────────────────────────
FROM alpine:3.19

RUN apk add --no-cache ca-certificates tzdata

COPY --from=builder /usr/local/bin/app     /usr/local/bin/app
COPY --from=builder /usr/local/bin/migrate /usr/local/bin/migrate
COPY docker/golang/entrypoint.sh           /entrypoint.sh

RUN chmod +x /entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/entrypoint.sh"]
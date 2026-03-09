FROM golang:1.26.1-alpine AS builder

WORKDIR /var/www/html

# Cache dependencies first
COPY go.mod ./
RUN go mod download

# Copy source code and build
COPY . .
RUN go build -v -o /usr/local/bin/app ./cmd/api

# ─── Runtime ──────────────────────────────────────────────────────────────────
FROM alpine:3.19

COPY --from=builder /usr/local/bin/app /usr/local/bin/app

CMD ["app"]
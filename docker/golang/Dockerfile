# syntax=docker/dockerfile:1

FROM golang:1.18-alpine

WORKDIR /goapp

COPY go.mod ./
COPY go.sum ./
RUN go mod download

COPY *.go ./
RUN go build -o /docker-go

EXPOSE 8070

CMD [ "/docker-go" ]

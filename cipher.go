package main

import (
    "fmt"
    "github.com/dgrijalva/jwt-go"
)

func main() {
    tokenString := "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2F1dGgvbG9naW4iLCJpYXQiOjE2NDk5NTIyMjIsImV4cCI6MTY0OTk1NTgyMiwibmJmIjoxNjQ5OTUyMjIyLCJqdGkiOiJMNkxNaE9zVmFKalZVc3JNIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.9CUc62yf98rf1NateBNXTa5ZM4Zzi_HAoDaZtJvgvqA"
    tokenKey := "9Qq0IlN66iTfXUYZW1mlOF6tbmPILbSkpI91rxY8u2wNas9mrK17p1Kcbz39Zc82"
    claims := jwt.MapClaims{}
    _, err := jwt.ParseWithClaims(tokenString, claims, func(token *jwt.Token) (interface{}, error) {
        return []byte(tokenKey), nil
    })

    if err != nil {
        fmt.Println(err)
    }

    userId := claims["sub"]

    fmt.Println(userId)
}

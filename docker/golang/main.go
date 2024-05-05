package main

import (
	"github.com/gin-gonic/gin"
	"database/sql"
	"net/http"
	"math/rand"
	"strings"
	"strconv"
	_ "github.com/lib/pq"
    "encoding/base64"
)

type game struct{
    win_combination string
}

func main() {
	r := gin.Default()

	r.POST("/results", func(c *gin.Context) {
		connStr := "user=postgres password=postgres dbname=db host=db sslmode=disable"
        db, err := sql.Open("postgres", connStr)

        var winNumbers string
        var encryptedWinNumbers string
		numbers := c.PostForm("numbers")
		userId := c.PostForm("userId")

        if err != nil {
            panic(err)
        }

        defer db.Close()

        row := db.QueryRow("SELECT (win_combination) FROM games WHERE user_id = $1 AND is_ended = false", userId)
		g := game{}
		err = row.Scan(&g.win_combination)

		if err != nil {
			winNumbers = generateWinCombination()
			encryptedWinNumbers = base64.StdEncoding.EncodeToString([]byte(winNumbers))
			_, err2 := db.Exec("insert into games (user_id, win_combination) values ($1, $2)", userId, encryptedWinNumbers)
            if err2 != nil{
				panic(err2)
            }
		} else {
			encryptedWinNumbers = g.win_combination
		}

        decryptedWinNumbers := string(Decode(encryptedWinNumbers))

		bulls, cows := getResult(numbers, decryptedWinNumbers)

		_, err3 := db.Exec("UPDATE games SET count_attempts = count_attempts + 1 WHERE user_id = $1 AND is_ended = false", userId)
		if err3 != nil{
			panic(err3)
		}

		c.JSON(http.StatusOK, gin.H{
			"bulls": bulls,
			"cows": cows,
		})
	})
	r.Run(":8070")
}

func generateWinCombination() (string) {
	var winNumbers string
	for len(winNumbers) < 4 {
		randNumber := rand.Intn(10)
		if (!strings.Contains(winNumbers, strconv.Itoa(randNumber))) {
			winNumbers = winNumbers + strconv.Itoa(randNumber)
		}
	}
	return winNumbers
}

func getResult(numbers string, winCombination string) (int, int) {
	bulls := countBulls(numbers, winCombination)
	cows := countCows(numbers, winCombination)
	return bulls, cows
}

func countBulls(numbers string, winCombination string) (int) {
	numberOfBulls := 0
	for i := 0; i < len(winCombination); i++ {
		if (winCombination[i] == numbers[i]) {
			numberOfBulls++
		}
	}
	return numberOfBulls
}

func countCows(numbers string, winCombination string) (int) {
	numberOfCows := 0
	for i := 0; i < len(winCombination); i++ {
		if (numbers[i] != winCombination[i] && strings.Contains(winCombination, string(numbers[i]))) {
			numberOfCows++
		}
	}
	return numberOfCows
}

func Decode(s string) []byte {
     data, err := base64.StdEncoding.DecodeString(s)
     if err != nil {
        panic(err)
     }
     return data
}

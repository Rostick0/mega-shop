package controller

import (
    "encoding/json"
    "net/http"
)

func writeJSON(w http.ResponseWriter, status int, data any) {
    w.Header().Set("Content-Type", "application/json")
    w.WriteHeader(status)
    json.NewEncoder(w).Encode(data)
}

func writeErr(w http.ResponseWriter, status int, err error) {
    msg := "unknown error"
    if err != nil {
        msg = err.Error()
    }
    writeJSON(w, status, map[string]string{"error": msg})
}
# -*- coding: utf-8 -*-
"""One-time OAuth authorization for the YouTube Data API v3 upload automation.

Run this once after downloading the OAuth client_secret JSON from Google
Cloud Console (APIs e Serviços -> Credenciais -> ID do cliente OAuth ->
Desktop app). It opens a browser for consent, then saves a reusable refresh
token to youtube_token.json (in the same folder) for the upload script to
use without ever prompting again.

Usage:
    python youtube_oauth_setup.py path/to/client_secret_XXXX.json
"""
import sys
from google_auth_oauthlib.flow import InstalledAppFlow

SCOPES = ["https://www.googleapis.com/auth/youtube.upload"]

def main():
    if len(sys.argv) != 2:
        print("Usage: python youtube_oauth_setup.py path/to/client_secret.json")
        sys.exit(1)

    client_secret_path = sys.argv[1]
    flow = InstalledAppFlow.from_client_secrets_file(client_secret_path, SCOPES)
    creds = flow.run_local_server(port=0)

    with open("youtube_token.json", "w", encoding="utf-8") as f:
        f.write(creds.to_json())

    print("OK - token salvo em youtube_token.json. Guarde este arquivo com cuidado (equivale a uma senha).")

if __name__ == "__main__":
    main()

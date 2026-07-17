# -*- coding: utf-8 -*-
"""Upload a video to YouTube via the Data API v3, using the refresh token
saved by youtube_oauth_setup.py.

Vertical videos under 3 minutes are automatically treated as Shorts by
YouTube — no special flag needed, just the right aspect ratio/duration
(all our Reels already qualify: 1080x1920, well under 60s).

Usage:
    python youtube_upload.py \
        --file "C:/rmp/out/dica7-validacao.mp4" \
        --title "Validação de Dados no Excel #Shorts" \
        --description "..." \
        --tags "excel,powerbi,dica" \
        --privacy private \
        --publish-at "2026-07-20T09:00:00-03:00"   # optional, requires privacy=private
"""
import argparse
import os
import sys

from google.oauth2.credentials import Credentials
from google.auth.transport.requests import Request
from googleapiclient.discovery import build
from googleapiclient.http import MediaFileUpload

TOKEN_PATH = os.path.join(os.path.dirname(__file__), "youtube_token.json")
SCOPES = ["https://www.googleapis.com/auth/youtube.upload"]


def get_credentials():
    creds = Credentials.from_authorized_user_file(TOKEN_PATH, SCOPES)
    if creds.expired and creds.refresh_token:
        creds.refresh(Request())
        with open(TOKEN_PATH, "w", encoding="utf-8") as f:
            f.write(creds.to_json())
    return creds


def upload(file_path, title, description, tags, category_id, privacy, publish_at):
    creds = get_credentials()
    youtube = build("youtube", "v3", credentials=creds)

    status = {"privacyStatus": privacy, "selfDeclaredMadeForKids": False}
    if publish_at:
        if privacy != "private":
            raise ValueError("publish_at (agendamento) exige privacyStatus='private'")
        status["publishAt"] = publish_at

    body = {
        "snippet": {
            "title": title,
            "description": description,
            "tags": tags.split(",") if tags else [],
            "categoryId": category_id,
        },
        "status": status,
    }

    media = MediaFileUpload(file_path, chunksize=-1, resumable=True, mimetype="video/mp4")
    request = youtube.videos().insert(part="snippet,status", body=body, media_body=media)

    response = None
    while response is None:
        status_progress, response = request.next_chunk()
        if status_progress:
            print(f"Upload {int(status_progress.progress() * 100)}%")

    return response


def main():
    p = argparse.ArgumentParser()
    p.add_argument("--file", required=True)
    p.add_argument("--title", required=True)
    p.add_argument("--description", default="")
    p.add_argument("--tags", default="")
    p.add_argument("--category-id", default="27")  # 27 = Education
    p.add_argument("--privacy", default="private", choices=["private", "unlisted", "public"])
    p.add_argument("--publish-at", default=None, help="ISO 8601 com offset, ex: 2026-07-20T09:00:00-03:00")
    args = p.parse_args()

    if not os.path.exists(args.file):
        print(f"Arquivo não encontrado: {args.file}")
        sys.exit(1)

    result = upload(args.file, args.title, args.description, args.tags, args.category_id, args.privacy, args.publish_at)
    print("Upload concluído.")
    print("Video ID:", result["id"])
    print("URL:", f"https://youtube.com/watch?v={result['id']}")


if __name__ == "__main__":
    main()

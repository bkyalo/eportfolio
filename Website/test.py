import requests
from bs4 import BeautifulSoup
from urllib.parse import urljoin

# Target URL
base_url = "https://my.ouk.ac.ke/"

# Get the page content
response = requests.get(base_url, verify=False)  # verify=False to ignore SSL issues (if any)

# Check status
if response.status_code == 200:
    soup = BeautifulSoup(response.text, "html.parser")

    urls = set()  # To avoid duplicates

    # Extract all hrefs from <a>, <link>, <script>, <img>, <iframe>, etc.
    for tag in soup.find_all(["a", "link", "script", "img", "iframe"]):
        attr = "href" if tag.name in ["a", "link"] else "src"
        url = tag.get(attr)
        if url:
            full_url = urljoin(base_url, url)
            urls.add(full_url)

    # Print all URLs
    for link in sorted(urls):
        print(link)
else:
    print("Failed to retrieve page. Status code:", response.status_code)

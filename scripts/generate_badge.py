#!/usr/bin/env python3
"""Generate an SVG shield badge and write it to assets/badges/artifacts.svg."""
import sys, os, pathlib

count = sys.argv[1] if len(sys.argv) > 1 else "0"
color = "#007ec6"
label = "artifacts"

svg = (
    '<svg xmlns="http://www.w3.org/2000/svg" width="110" height="20">\n'
    '  <linearGradient id="s" x2="0" y2="100%">\n'
    '    <stop offset="0" stop-color="#bbb" stop-opacity=".1"/>\n'
    '    <stop offset="1" stop-opacity=".1"/>\n'
    "  </linearGradient>\n"
    '  <rect rx="3" width="110" height="20" fill="#555"/>\n'
    f'  <rect rx="3" x="60" width="50" height="20" fill="{color}"/>\n'
    f'  <path fill="{color}" d="M60 0h4v20h-4z"/>\n'
    '  <rect rx="3" width="110" height="20" fill="url(#s)"/>\n'
    '  <g fill="#fff" text-anchor="middle"'
    ' font-family="DejaVu Sans,Verdana,Geneva,sans-serif" font-size="11">\n'
    f'    <text x="30" y="14">{label}</text>\n'
    f'    <text x="85" y="14">{count}</text>\n'
    "  </g>\n"
    "</svg>\n"
)

out = pathlib.Path("assets/badges/artifacts.svg")
out.parent.mkdir(parents=True, exist_ok=True)
out.write_text(svg)
print(f"Badge written to {out} (count={count})")

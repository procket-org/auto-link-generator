**🌐 Sprachauswahl**:
[English](../README.md) |
[Deutsch](README-de_DE.md) |
[Español](README-es_ES.md) |
[Français](README-fr_FR.md) |
[日本語](README-ja.md) |
[한국어](README-ko_KR.md) |
[简体中文](README-zh_CN.md) |
[繁體中文](README-zh_TW.md)

---

# Auto Link Generator

**Auto Link Generator** ist ein WordPress-Plugin, das automatisch Tags oder Schlüsselwörter in Beiträgen in interne oder externe Links umwandelt, um die SEO-Leistung Ihrer Website zu verbessern und das Nutzererlebnis zu optimieren.

---

## ✨ Funktionen

- 🌐 Unterstützt mehrsprachige Schlüsselwort-Erkennung (u.a. Chinesisch, Japanisch, Koreanisch)
- 🏷️ Verwendet automatisch alle Beitrags-Tags als Schlüsselwörter
- 🔗 Wandelt Schlüsselwörter automatisch in Links um
- 🔍 Unterstützt case-sensitive Schlüsselwort-Erkennung
- ⚙️ Begrenzt die Anzahl ersetzter Links pro Beitrag
- 🚫 Ermöglicht das Ausschließen bestimmter Beiträge
- 🖥️ Admin-Oberfläche mit Vue.js für intuitive Bedienung
- 🔄 Vollständige WordPress REST API-Unterstützung

---

## 🧩 Plugin-Installation

1. ZIP-Paket des Plugins herunterladen
2. WordPress-Adminbereich öffnen: **Plugins > Installieren > Plugin hochladen**
3. ZIP-Datei hochladen, installieren und aktivieren

---

## ⚙️ Bedienungsanleitung

### Globale Einstellungen

1. Im WordPress-Adminbereich zu **Einstellungen > Auto Link** navigieren
2. Folgende Optionen konfigurieren:
    - **Automatische Tag-Erkennung**: Aktiviert die automatische Verwendung von Tags als Schlüsselwörter
    - **Groß-/Kleinschreibung**: Aktiviert case-sensitive Erkennung
    - **Maximale Links pro Beitrag**: Begrenzung automatisch erzeugter Links (0 = kein Limit)

### Beiträge ausschließen

- Bestimmte Beiträge von der automatischen Verlinkung ausschließen
- Ausschlussliste kann jederzeit bearbeitet werden

### Schlüsselwort-Verwaltung

- Schlüsselwörter hinzufügen und Ziel-URLs festlegen
- Bearbeiten, Löschen und Stapelverarbeitung möglich

---

## ⚙️ Funktionsweise

Das Plugin scannt Beitragsinhalte, erkennt definierte Tags/Schlüsselwörter und ersetzt sie durch Links. Dabei bleibt die HTML-Struktur erhalten, und Code-Blöcke werden nicht beeinflusst.

---

## 🔧 Technische Details

- **Frontend**: Vue.js + Axios
- **Backend**: WordPress REST API
- **Datenhaltung**: WordPress Options API

---

## ⚠️ Hinweise

- Zu viele automatische Links können das Nutzererlebnis beeinträchtigen
- Wichtige Beiträge sollten zur Ausschlussliste hinzugefügt werden

---

## ❓ FAQ

**F: Wie entferne ich Auto-Links für bestimmte Schlüsselwörter?**  
A: In der Schlüsselwort-Verwaltung das entsprechende Schlüsselwort löschen.

**F: Warum werden manche Schlüsselwörter nicht verlinkt?**  
A: Mögliche Gründe:
- Beitrag ist ausgeschlossen
- Maximale Linkanzahl erreicht
- Schlüsselwort befindet sich in HTML-Tags oder Code-Blöcken

**F: Wie verhindere ich, dass Tags auf Archivseiten verlinken?**  
A: Individuelle Schlüsselwörter haben Priorität. Ein Schlüsselwort mit dem Tag-Namen und eigener URL anlegen.

---

## 📄 Open-Source-Lizenz

Dieses Plugin steht unter [GPLv2 oder später](https://www.gnu.org/licenses/gpl-2.0.html).
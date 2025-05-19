**🌐 Choix de la langue**:
[English](../README.md) |
[Deutsch](README-de_DE.md) |
[Español](README-es_ES.md) |
[Français](README-fr_FR.md) |
[日本語](README-ja.md) |
[한국어](README-ko_KR.md) |
[简体中文](README-zh_CN.md) |
[繁體中文](README-zh_TW.md)

---

# Générateur de Liens Automatiques

**Générateur de Liens Automatiques** est une extension WordPress qui convertit automatiquement les mots-clés ou étiquettes dans vos articles en liens internes ou externes pour améliorer votre SEO et l'expérience utilisateur.

---

## ✨ Fonctionnalités

- 🌐 Prise en charge multilingue (incluant chinois, japonais, coréen)
- 🏷️ Utilise automatiquement les étiquettes comme mots-clés
- 🔗 Transforme les mots-clés en liens automatiquement
- 🔍 Respect de la casse configurable
- ⚙️ Limite du nombre de liens par article
- 🚫 Exclusion d'articles spécifiques possible
- 🖥️ Interface admin intuitive avec Vue.js
- 🔄 Support complet de l'API REST WordPress

---

## 🧩 Installation

1. Télécharger le fichier ZIP du plugin
2. Dans l'admin WordPress : **Extensions > Ajouter > Téléverser une extension**
3. Installer et activer l'extension

---

## ⚙️ Mode d'Emploi

### Réglages Globaux

1. Aller dans **Réglages > Auto Link**
2. Configurer les options :
    - **Correspondance auto des étiquettes** : Active l'usage des étiquettes comme mots-clés
    - **Sensibilité à la casse** : Active le respect des majuscules/minuscules
    - **Liens max par article** : Limite (0 = illimité)

### Exclure des Articles

- Sélectionner les articles à exclure
- La liste d'exclusion est modifiable

### Gestion des Mots-Clés

- Ajouter des mots-clés avec leurs URLs cibles
- Édition, suppression et opérations groupées disponibles

---

## ⚙️ Fonctionnement

Le plugin scanne le contenu, détecte les mots-clés définis et les remplace par des liens, tout en préservant la structure HTML.

---

## 🔧 Détails Techniques

- **Frontend** : Vue.js + Axios
- **Backend** : API REST WordPress
- **Stockage** : WordPress Options API

---

## ⚠️ Remarques

- Trop de liens automatiques nuit à l'expérience utilisateur
- Ajouter les articles importants à la liste d'exclusion

---

## ❓ FAQ

**Q: Comment supprimer un lien automatique ?**  
R: Dans la gestion des mots-clés, trouver et supprimer le mot-clé concerné.

**Q: Pourquoi certains mots-clés ne sont-ils pas liés ?**  
R: Raisons possibles :
- Article exclu
- Limite de liens atteinte
- Mot-clé dans du code HTML

**Q: Comment éviter que les étiquettes lient vers leurs archives ?**  
R: Les mots-clés personnalisés ont priorité. Créez-en un avec le même nom et votre URL souhaitée.

---

## 📄 Licence

Ce plugin est sous licence [GPLv2 ou ultérieure](https://www.gnu.org/licenses/gpl-2.0.html).
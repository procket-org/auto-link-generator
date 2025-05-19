**🌐 Selección de idioma**:
[English](../README.md) |
[Deutsch](README-de_DE.md) |
[Español](README-es_ES.md) |
[Français](README-fr_FR.md) |
[日本語](README-ja.md) |
[한국어](README-ko_KR.md) |
[简体中文](README-zh_CN.md) |
[繁體中文](README-zh_TW.md)

---

# Generador de Enlaces Automáticos

**Generador de Enlaces Automáticos** es un plugin de WordPress que convierte automáticamente etiquetas o palabras clave en publicaciones en enlaces internos o externos para mejorar el SEO de tu sitio web y optimizar la experiencia de usuario.

---

## ✨ Características

- 🌐 Soporte multilingüe para palabras clave (incluyendo chino, japonés, coreano)
- � Usa automáticamente todas las etiquetas como palabras clave
- 🔗 Convierte palabras clave en enlaces automáticamente
- 🔍 Soporta coincidencia sensible a mayúsculas/minúsculas
- ⚙️ Limita el número de enlaces por publicación
- 🚫 Permite excluir publicaciones específicas
- 🖥️ Interfaz administrativa con Vue.js para operación intuitiva
- 🔄 Soporte completo para WordPress REST API

---

## 🧩 Instalación del Plugin

1. Descargar el paquete ZIP del plugin
2. Acceder al panel de WordPress: **Plugins > Añadir nuevo > Subir plugin**
3. Subir el archivo ZIP, instalar y activar

---

## ⚙️ Guía de Uso

### Configuración Global

1. Ir a **Ajustes > Auto Link** en el panel de WordPress
2. Configurar las opciones:
    - **Coincidencia automática de etiquetas**: Usa etiquetas como palabras clave
    - **Sensible a mayúsculas**: Habilita coincidencia exacta
    - **Máximo de enlaces**: Límite por publicación (0 = sin límite)

### Excluir Publicaciones

- Seleccionar publicaciones para excluir del autoenlazado
- La lista de exclusión es editable

### Gestión de Palabras Clave

- Añadir palabras clave con sus URLs destino
- Editar, eliminar y operaciones por lotes disponibles

---

## ⚙️ Funcionamiento

El plugin escanea el contenido, detecta palabras clave definidas y las reemplaza por enlaces, manteniendo intacta la estructura HTML.

---

## 🔧 Detalles Técnicos

- **Frontend**: Vue.js + Axios
- **Backend**: WordPress REST API
- **Almacenamiento**: WordPress Options API

---

## ⚠️ Notas

- Demasiados enlaces automáticos pueden afectar la experiencia
- Añade publicaciones importantes a la lista de exclusión

---

## ❓ Preguntas Frecuentes

**P: ¿Cómo elimino el autoenlace de una palabra clave?**  
R: En la gestión de palabras clave, localízala y elimínala.

**P: ¿Por qué algunas palabras no se convierten en enlaces?**  
R: Posibles causas:
- La publicación está excluida
- Se alcanzó el límite de enlaces
- La palabra está dentro de código HTML

**P: ¿Cómo evito que las etiquetas enlacen a sus archivos?**  
R: Las palabras clave personalizadas tienen prioridad. Crea una con el mismo nombre y tu URL deseada.

---

## 📄 Licencia

Este plugin usa licencia [GPLv2 o posterior](https://www.gnu.org/licenses/gpl-2.0.html).
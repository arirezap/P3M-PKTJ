# Panduan Agent Proyek Website P3M PKTJ

<!-- antislop:start -->
## antislop
For UI, copy, people, mobile layout, or code comments work, read `.agents/skills/antislop/SKILL.md` (core) and then the skill for the task:
- UI / visual: `.agents/skills/antislop-ui/SKILL.md`
- Copy & text: `.agents/skills/antislop-copywriting/SKILL.md`
- People: `.agents/skills/antislop-human/SKILL.md`
- Mobile / responsive: `.agents/skills/antislop-layoutmobile/SKILL.md`
- Code comments: `.agents/skills/antislop-code/SKILL.md`

Before starting, follow the core's "Two Usage Modes" section in strict order: explicit session instruction first, then global preference, then ask. A session instruction always wins. For a resolved mode, say `antislop active: <mode> (session override).` or `antislop active: <mode> (global preference).` once before presenting findings or making edits, using the actual mode and source.

Arah desain utama mengacu pada [design.md](design.md) dan arsitektur fitur pada [PERENCANAAN_PROYEK_P3M.md](PERENCANAAN_PROYEK_P3M.md).

### 📱 Mandat Responsivitas Multi-Device (PC, Laptop, Tablet, Smartphone)
Setiap antarmuka yang dibuat atau diedit wajib mematuhi standar multi-device berikut:
1. **Fluid across breakpoints**: Wajib teruji dan tertata rapi di Smartphone (`< 640px`), Tablet (`640px - 1023px`), Laptop (`1024px - 1279px`), dan Desktop (`≥ 1280px`).
2. **Zero horizontal overflow**: Dilarang ada pergeseran layar horizontal (*no horizontal scrollbar*) pada mobile selain wadah tabel/data khusus.
3. **Touch ergonomics**: Elemen interaktif (tombol, input, link dropdown) minimal berukuran 44x44px untuk kemudahan tap pada layar sentuh.
4. **Adaptive Navigation & Tables**: Gunakan mobile drawer yang rapi pada smartphone/tablet dan penyajian tabel/grafik yang dapat menyesuaikan lebar layar secara otomatis.

### 📐 Mandat Sistem Spasial Grid 4px (Strict 4px Multiples Rule)
Seluruh styling antarmuka (Tailwind CSS) wajib tunduk pada kelipatan 4 pixel:
1. **Dimensi Spasial**: Semua margin, padding, gap, lebar, dan tinggi elemen wajib menggunakan skala kelipatan 4px (`p-1`=4px, `p-2`=8px, `p-3`=12px, `p-4`=16px, `p-5`=20px, `p-6`=24px, `p-8`=32px, `p-10`=40px, `p-12`=48px, dst).
2. **Tanpa Angka Acak/Ganjil**: Dilarang keras menggunakan arbitrary class bernilai ganjil / acak di luar kelipatan 4px (seperti `p-[13px]`, `m-[7px]`, `h-[37px]`).
3. **Line-Height & Radius**: Line height tipografi wajib mengunci kelipatan 4px (`leading-4`=16px, `leading-5`=20px, `leading-6`=24px, `leading-7`=28px, `leading-8`=32px, `leading-10`=40px) dan border-radius kelipatan 4 (`rounded`=4px, `rounded-lg`=8px, `rounded-xl`=12px, `rounded-2xl`=16px).
<!-- antislop:end -->

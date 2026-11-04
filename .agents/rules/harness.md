---
trigger: "harness, pipeline, ci-cd, security-scan, secret-scan"
description: Pedoman penggunaan Harness Skills dan Pipeline CI/CD v1 untuk otomasi pengujian, build, dan keamanan kode.
---

## Harness Skills & Pipeline Guidelines

Repositori proyek ini menggunakan ekosistem Harness Skills untuk manajemen alur kerja CI/CD, audit keamanan, dan operasional pipeline.

### Pedoman Penggunaan:
1. **Penyusunan Pipeline v1**:
   - Selalu gunakan sintaks Harness Pipeline v1 modern (`.harness/pipeline.yaml`).
   - Gunakan format hierarki datar (*flat stages*), ekspresi `${{ }}`, dan langkah aksi natif.
   - Rujukan skema lengkap tersimpan pada `.agents/skills/harness-pipeline/references/v1-spec-schema.md`.
2. **Keamanan & Pemindaian Kode**:
   - Gunakan skill `.agents/skills/harness-security/SKILL.md` untuk konfigurasi SAST dan SCA.
   - Gunakan skill `.agents/skills/harness-security/SECRET_SCAN.md` untuk konfigurasi secret scanning (Gitleaks).
   - Pastikan setiap perubahan kode melewati pemeriksaan `composer audit` dan deteksi kebocoran kredensial.
3. **Pengujian Otomatis**:
   - Pipeline wajib memvalidasi kelulusan 100% dari seluruh 148 tes unit & fitur (`php artisan test`).
4. **Diagnosis Kegagalan**:
   - Jika eksekusi pipeline mengalami kendala, rujuk `.agents/skills/harness-debug/SKILL.md` untuk isolasi log dan analisis *bottleneck*.
5. **Kebijakan Bahasa & Format**:
   - Dilarang menyertakan kata "resmi" dan dilarang menyertakan emoji dalam konfigurasi maupun catatan pipeline.


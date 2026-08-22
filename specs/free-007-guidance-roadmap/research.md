# Research — SPEC-FREE-007

## Trazabilidad F-EVAL → resolución

| Hallazgo | Resolución en este SPEC |
|----------|------------------------|
| F-EVAL-02 lenguaje | D-F704 user_label contextual + gate G4 (cero códigos internos en texto usuario) |
| F-EVAL-03 sin_evaluar | D-F705 attention_notice + sección evaluar ordenada HIGH→MEDIUM (G1/G2) |
| F-EVAL-04 KD permanentes | translate_review_reasons() con frase explicativa + KD ref (G5) |
| F-EVAL-07 primera sesión | summary_phrase + roadmap sections = guion exacto para la UI de FREE-008 |
| F-EVAL-01 superficie | Fuera de alcance aquí → requisito duro de FREE-008 |

## Hallazgos propios

| ID | Descripción | Estado |
|----|-------------|--------|
| F7-01 | Bug: usort dirección invertida ordenaba MEDIUM antes que HIGH | FIXED |
| F7-02 | Test falso-negativo: json_encode escapa 'ó'→\u00f3; strpos UTF-8 crudo falla. Comparar strings reales, no JSON | FIXED (lección: igual que F6-01, expectativas/método de test) |
| F7-03 | Descubrimiento de diseño: frase terminal nunca será "Todo cubierto" mientras existan KDs — correcto por D-F402 | DOCUMENTED (D-F703) |

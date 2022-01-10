# Testes unitários e TDD com PHP e PHPUnit

Repositório para gravar os testes unitários e TDD com PHP e PHPUnit feitos na aula da udemy.

## Quebrar em produção

* Prejuizo Financeiro
  * Custo de mídia ou propagandas
  * Custo de oportunidade

* Qualidade de Vida
  * Estresse
  * Trabalhar até tarde/final de semana
  
* Limitações no processo de desenvolvimento
  * Deploys em dias ou horarios específicos
  * Pessas validando tudo

## Testes manuais

* Mais lentos
* Não exploram muitos cenários
* Talvez não tão confiáveis
* Adiciona uma etapa ao processo
* Caros

## Testes automatizados

* Mais rápidos
* Aplicação muito mais estável
* Aumenta confiança do time
* Melhora o levantamento de requisitos
* Documenta as regras de negócio
* Menor custo


Exemplo:

```code
class SearchTest {
    shouldShowBioTest {
        $google = new Google();
        $page = $google->search('Obama');

        assertTrue($page->hasBio());
    }

    shouldShowCalculatorTest {
        $google = new Google();
        $page = $google->search('1+1');

        assertTrue($page->hasCalculator());
    }

    shouldShowNotFoundMessageTest {
        $google = new Google();
        $page = $google->search('asidiashdiaudiuahidaidhasudhasd');
        
        assertTrue($page->hasNotFoundMessage());
    }
}

```
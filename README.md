# Testes unitários e TDD com PHP e PHPUnit

Repositório para gravar os testes unitários e TDD com PHP e PHPUnit feitos na aula da udemy.

## Seção 1 - Introdução
### Quebrar em produção

* Prejuizo Financeiro
  * Custo de mídia ou propagandas
  * Custo de oportunidade
* Qualidade de Vida
  * Estresse
  * Trabalhar até tarde/final de semana
* Limitações no processo de desenvolvimento
  * Deploys em dias ou horarios específicos
  * Pessas validando tudo

### Testes manuais

* Mais lentos
* Não exploram muitos cenários
* Talvez não tão confiáveis
* Adiciona uma etapa ao processo
* Caros

### Testes automatizados

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
## Seção 2 - Criando nosso próprio framework de teste

Criação do framework de testes

> Conteúdo criado na aula_1

## Seção 3 - Diferenciando os tipos de testes

### Testes de Integração / Funcional / Fim a Fim

* Testa a aplicação de forma integrada
  * broad integration teste
  * narrow integration teste
* Cobre mais código nos primeiros teste
* Bons pra começar
* Mais lentos e configuração do ambiente mais trabalhosa
* Mais difícil de encontrar motivo da falha

### Testes Unitários / Testes de Unidade

* Testa de forma contextual
* Mais rádidos
* Mais fácil de encontrar falhas
* Mais testes para chegar numa boa cobertura
* Setup mais simples

## Seção 4 - Instalação PHPUnit

Site PHPUnit: https://phpunit.de/

Na minha versão de estudo eu utilizo o composer para fazer a instalação do PHPUnit.

## Seção 5 - Praticando com aplicação de mercado

### Utilização do @dataProvider

Implementação do @dataPRovider é feita quando temos varios senarios de testes que podem utilizar a mesma estrutra de código somente variando os valores de entrada.

Um bom exemplo esta em: aula_2/src/OrderBundle/Test/Validators/NotEmptyValidatorTest.php

```code
use OrderBundle\Validators\NotEmptyValidator;
use PHPUnit\Framework\TestCase;

class NotEmptyValidatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult)
    {
        $notEmptyValidator = new NotEmptyValidator($value);

        $isValid = $notEmptyValidator->isValid();

        $this->assertEquals($expectedResult, $isValid);
    }

    public function valueProvider()
    {
        return [
            'shouldBeValidWhenValueIsNotEmpty' => ['value' => 'foo', 'expectedResult' => true],
            'shouldNotBeValidWhenValueIsEmpty' => ['value' => '', 'expectedResult' => false]
        ];
    }
```

### Melhorias de nomenclaturas de cenarios

Padrões fortemente aceitos nas comunidades:

```text
shouldBeValidWhenValueIsANumber

whenValueIsANumberShouldBeValid
```

Também podemos atribuir um sistema de linguagem de nomenclatura mais baseado no cenário do teste, como por exemplo:

```text
should_BeValid_When_ValueIsANumber

IsValid_ValuesANumber_True

IsValid_True_ValueIsANumber

BeValidIfVAluesIsANumber
```

Mas o que realmente importa é que o nome tenha corresponda a essas questões:

* O que está sendo testado?
* Quais as circunstâncias?
* Qual resultado esperado?
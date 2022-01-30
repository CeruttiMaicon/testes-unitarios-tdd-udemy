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

## Seção 6 - Dominando dublês de teste

### Trabalhando com Stubs

Stubs são objetos que simulam outros objetos. Para evitar dependências externas, podemos criar um objeto que simula o comportamento de outro objeto.

Ele faz com que uma determinada classe tenha apenas um retorno durante a chamada do método. Assim focando apenas na classe que se está testando sem se preocupar com as dependências.

Pode ser utilizado da seguinte maneira:

```code
/**
* @test
*/
public function hasBadWords()
{
    $badWords = ['bad', 'words'];
    $text = 'This is a bad word';

    $badWordRepository = $this->createMock(BadWordFilter::class);
    
    $badWordRepository->method('findAll')->willReturn(['bobo', 'besta', 'chule']);

    $hasBadWords = $badWordValidator->hasBadWords('Seu restaurante e muito bobo');

    $this->assertEquals(true, $hasBadWords);
}

```

### Trabalhando com Mocks

Possui a mesma caracteristica dos Stubs, porem o mock é um objeto que simula o comportamento de um objeto real.

> Um mock pode fazer os `asserts` das funções do objeto.

```code
/**
* @test
*/
public function shouldSaveWhenReceivePoints()
{
    $pointsRepository = $this->createMock(PointsRepository::class);
    $pointsRepository->expects($this->once())
        ->method('save');

    $pointsCalculator = $this->createMock(PointsCalculator::class);
    $pointsCalculator->method('calculatePointsToReceive')
        ->willReturn(100);

    $allMessages = [];
    $logger = $this->createMock(LoggerInterface::class);
    $logger->method('log')
        ->will($this->returnCallback(
            function ($message) use (&$allMessages) {
                $allMessages[] = $message;
            }
        ));

    $fidelityProgramService = new FidelityProgramService(
        $pointsRepository,
        $pointsCalculator,
        $logger
    );

    $customer = $this->createMock(Customer::class);
    $value = 50;
    $fidelityProgramService->addPoints($customer, $value);

    $expectedMessages = [
        'Checking points for customer',
        'Customer received points'
    ];
    $this->assertEquals($expectedMessages, $allMessages);
}
```

### Fakes

Basicamente um fake da um retorno para uma função, com um valor especifico para ser utilizado no teste. Um exemplo foi, criar uma função que tenha os retornos, um especifico para cada tipo de teste.

Este método pode ser facilmente substituido por Mocks.

### Retornando mocks dependendo dos parâmetros

```code
$map = [
    [
        'foo' => 'bar',
        'bar' => 'baz',
        false   
    ],
    [
        'foo' => 'bar',
        'bar' => 'baz',
        true
    ]
];

$httpClient->method('send')
    ->expects($this->once())
    ->will($this->returnValueMap($map))
```
> obs: O parametro extra enviado é o valor que será retornado.

#### Expects

```code
// Ele espera que este metodo seja chamado apenas uma vez
->expects($this->once())


// Ele espera que este metodo seja chamado pelo menos 2 vezes
->expects($this->atList(2))
```

### Retorno de mocks dependendo da ordem da chamada

Para isso, podemos utilizar do seguinte:

```code
$httpClient->method('send')
    // Que represena o valor da primeira chamada, assim podendo utilizar do willReturn
    ->expects($this->at(0))
    // Agora passando diretamente o valor do retorno esperado do teste
    ->willReturn(['token' => '12345']);

$httpClient->method('send')
    ->expects($this->at(1))
    // Agora passando diretamente o valor do segundo retorno esperado
    ->willReturn(['paid' => false]);
```

#### Outra maneira de fazer isso com base na quantidade de chamadas

```code
$httpClient->method('send')
    ->expects($this->atLast(2))
    // Agora passando diretamente o valor do segundo retorno esperado
    ->will(onConsecutiveCalls(
        ['token' => '12345'],
        ['paid' => false]
    ));

```

## Seção 7 - Melhorando a organização dos testes
### Testando exceções

Criando um exemplo de caso de Excessão:

```code
$httpClient->method('send')
    // No caso de teste da excessão o metodo send() não deve ser chamado
    ->expects($this->never())
    ->method('send');

$this->expectException(InvalidArgumentException::class);
```

> InvalidArgumentException é a classe que faz o caso de teste falhar.

Também é possível fazer este mesmo teste com anotation:
```code
/**
* @test
* @expectedException InvalidArgumentException
*/
public function shouldNotSendWhenInvalidArgument()
{
    $httpClient->send('invalid');
}
```

Que possui a mesma funcionalidade do teste acima, mas utilizando a anotação.

### Setup e Teardown

setup() e tearDown() são métodos que são executados antes e depois de cada funçaõ de teste.

```code
public function setUp()
{
    ...
}

public function tearDown()
{
    ...
}

// Obrigatóriamente deve ser estático
public static function setupBeforeClass()
{
    ...
}

// Obrigatóriamente deve ser estático
public static function teardownAfterClass()
{
    ...
}
```

#### Setup

Geralmente utilizada para criar objetos (mocks e dummies) que serão utilizados nos testes.

A função é executada antes de cada teste.

```code
class PaymentServiceTest extends TestCase
{
    private $gateway;
    private $paymentTransactionRepository;
    private $paymentService;
    private $customer;
    private $item;
    private $creditCard;

    public function setUp()
    {
        $this->gateway = $this->createMock(Gateway::class);
        $this->paymentTransactionRepository = $this->createMock(PaymentTransactionRepository::class);
        $this->paymentService = new PaymentService($this->gateway, $this->paymentTransactionRepository);

        $this->customer = $this->createMock(Customer::class);
        $this->item = $this->createMock(Item::class);
        $this->creditCard = $this->createMock(CreditCard::class);
    }
...
}
```
> Cuidado: Nunca utilizar o setup para ficar com parte do cenário de teste

#### Teardown

Geralmente mais utilizada para casos de teste integração, onde é necessário executar alguma função depois de executar o teste (limpar cache, fechar conexão, etc).

Está função é executada no final de cada teste.

#### SetupBeforeClass e TeardownAfterClass

Também utilizada para casos de teste integração, onde é necessário executar alguma função depois de executar o teste (limpar cache, fechar conexão, etc).

SetupBeforeClass: Está função é executada no inicio de cada classe de teste.

TeardownAfterClass: Está função é executada no final de cada classe de teste.

### Escrevendo boas asserções

```code
// O terceiro parametro é uma mensagem customizada para o teste
$this->assertEquals(1, $this->paymentService->getTotalAmount(), 'Total amount is not correct');
```

**Para cada teste, é importante que se teste apenas uma responsabilidade de cada vez.**

### Classes grandes e legibilidade dos cenários

> Ao refatorar uma função extensa, o ideal seria primeiramente fazer os testes para garantir que nenhuma funcionalidade será removida indevidamente.

### Usando Fluent Interface para melhorar testes grandes

Um metodo para reduzir os testes é separar o código repetitivo em funções menores. Assim justificando a utilização de Fluent Interface.

Fluent Interface: é quando a função retorna o próprio objeto, assim possibilitando fazer varias chamadas de função incadeadas.

Um exemplo:

```code
private $orderService;

public function withOrderService()
{

    // Aqui ficaria a instancia que é repetitiva na classe de teste
    $this->orderService = new OrderService(
        $this->createMock(OrderRepository::class),
        $this->createMock(OrderItemRepository::class),
        ...
    );

    //Por padrão ela sempre retornará o próprio objeto
    return $this;
}

```

Agora para implementalo em uma classe, basta fazer:

```code

public function testShouldCreateOrder()
{
    $this->withOrderService();

    $this->orderService->createOrder(
        $this->customer,
        $this->item,
        $this->creditCard
    );
}
```

Agora todas as funções que precisam usar `new OrderService` são separadas em funções menores. E podem utilizar simplesmete `$this->withOrderService()`.

## Coberturas de testes

Primeiramente devemos entrar e entender o arquivo de configuração XML do PhpUnit.

Alguns atributos:

colors: Ativa ou desativa a cor do texto dos testes.

logging: Ativa ou desativa o log dos testes.
  * Opção: coverage-html

Ele gera um arquivo html que mostra a cobertura de testes.
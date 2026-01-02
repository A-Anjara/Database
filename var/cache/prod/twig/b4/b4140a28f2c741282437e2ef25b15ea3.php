<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* database/index.html.twig */
class __TwigTemplate_158b8b55f542220f8ddee2d3311448cd extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "BSpaydb
";
        yield from [];
    }

    // line 7
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 8
        yield "
\t<input type=\"hidden\" value=\"";
        // line 9
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fetch_user_info");
        yield "\" id='apiGetUser'>
\t<input type=\"hidden\" value=\"";
        // line 10
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fetch_user_parrainage");
        yield "\" id='apiGetParrainage'>
\t<input type=\"hidden\" value=\"";
        // line 11
        yield $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fetch_user_transaction");
        yield "\" id='apiGetTransaction'>


\t<section>
\t\t<h1 class=\"text-xl md:text-2xl  font-bold text-teal-950 py-3\">Mettre à jour la Base de donnée</h1>
\t\t";
        // line 16
        yield         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["form"] ?? null), 'form_start', ["attr" => ["class" => "py-2 flex", "data-controller" => "form"]]);
        yield "

\t\t<button type=\"submit\" class=\"bg-teal-500 p-2  text-white font-semibold \">
\t\t\tValider
\t\t</button>

\t\t<label for=\"";
        // line 22
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\FormExtension']->getFieldId(CoreExtension::getAttribute($this->env, $this->source, ($context["form"] ?? null), "excelFile", [], "any", false, false, false, 22)), "html", null, true);
        yield "\" class=\"bg-teal-100 p-2 min-w-1/4 block hover:bg-teal-200\" data-form-target=\"output\">
\t\t\tD&eacute;poser le fichier excel ici
\t\t</label>
\t\t<input type=\"file\" name=\"";
        // line 25
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\FormExtension']->getFieldName(CoreExtension::getAttribute($this->env, $this->source, ($context["form"] ?? null), "excelFile", [], "any", false, false, false, 25)), "html", null, true);
        yield "\" id=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Symfony\Bridge\Twig\Extension\FormExtension']->getFieldId(CoreExtension::getAttribute($this->env, $this->source, ($context["form"] ?? null), "excelFile", [], "any", false, false, false, 25)), "html", null, true);
        yield "\" class=\"hidden\" data-form-target=\"input\" data-action=\"input->form#changeFileValue\"/>
\t\t";
        // line 26
        CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["form"] ?? null), "excelFile", [], "any", false, false, false, 26), "setRendered", [], "any", false, false, false, 26);
        // line 27
        yield "\t\t";
        yield         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["form"] ?? null), 'form_end');
        yield "
\t\t";
        // line 28
        if ((($tmp = ($context["error"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 29
            yield "\t\tError: ";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error"] ?? null), "html", null, true);
            yield "
\t\t";
        }
        // line 31
        yield "\t\t
\t</section>


\t<section class=\"my-4\">
\t\t<h1 class=\"text-xl md:text-2xl text-center  font-bold text-teal-950 py-3\">Liste des utilisateurs</h1>
\t\t<div class=\"max-w-screen overflow-scroll max-h-[75vh] border-t-2 border-teal-950\">
\t\t\t<table class=\"border-collapse min-w-screen\">
\t\t\t\t<thead class=\"bg-teal-100 sticky top-0 \">
\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">ID</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Nom</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Email</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Code</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Adresse</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Telephone</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Fokontany</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Activite</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Nif</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Personne</th>
\t\t\t\t\t\t<th class=\"border border-teal-950/50 p-2\">Date</th>
\t\t\t\t\t</tr>
\t\t\t\t</thead>
\t\t\t\t<tbody>
\t\t\t\t\t";
        // line 55
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["utilisateurs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 56
            yield "
\t\t\t\t\t\t<tr class=\"bg-teal-100/50 hover:bg-teal-200\" data-controller=\"modal\" data-action=\"click->modal#openModal\">
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 58
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "id", [], "any", false, false, false, 58), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 59
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "nom", [], "any", false, false, false, 59), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 60
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "email", [], "any", false, false, false, 60), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2 text-nowrap\">";
            // line 61
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "code", [], "any", false, false, false, 61), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 62
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "adresse", [], "any", false, false, false, 62), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 63
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "telephone", [], "any", false, false, false, 63), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 64
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "fokontany", [], "any", false, false, false, 64), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 65
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "activite", [], "any", false, false, false, 65), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 66
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "nif", [], "any", false, false, false, 66), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"border border-teal-950/50 p-2\">";
            // line 67
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["row"], "personne", [], "any", false, false, false, 67), "html", null, true);
            yield "</td>
\t\t\t\t\t\t\t<td class=\"text-nowrap border border-teal-950/50 p-2\" data-controller=\"date\" data-date-date-value=\"";
            // line 68
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["row"], "date", [], "any", false, false, false, 68), "date", [], "any", false, false, false, 68), "html", null, true);
            yield "\"></td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['row'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 71
        yield "\t\t\t\t</tbody>
\t\t\t</table>
\t\t</div>


\t</section>


\t<!-- MODAL CONTENEUR -->
\t<div
\t\tclass=\"fixed bottom-0 left-0 w-full p-3 bg-black/40 flex items-center justify-center hidden\" id=\"modalContainer\">
\t\t<!-- MODAL -->
\t\t<div
\t\t\tclass=\"bg-white flex flex-col items-stretch relative \">

\t\t\t<!-- MODAL TABS -->
\t\t\t<div class=\" flex bg-teal-800 items-center w-full text-white\">
\t\t\t\t<div class=\"cursor-default flex items-center justify-center p-2 bg-red-500 hover:bg-red-600 text-white \" ";
        // line 88
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusController("modal");
        yield " ";
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusAction("modal", "closeModal", "click");
        yield ">
\t\t\t\t\t<span>&Cross;</span>
\t\t\t\t</div>
\t\t\t\t<label for=\"infoTab\" class=\"p-2  hover:bg-white hover:text-black [&[active]]:bg-white [&[active]]:text-black \" id=\"modalRadioInfo\" ";
        // line 91
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusController("modal");
        yield " ";
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusAction("modal", "loadInfo", "click");
        yield ">Info</label>
\t\t\t\t<label for=\"parrainageTab\" class=\"p-2  hover:bg-white hover:text-black [&[active]]:bg-white [&[active]]:text-black\" id=\"modalRadioParrainage\" ";
        // line 92
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusController("modal");
        yield " ";
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusAction("modal", "loadParrainage", "click");
        yield ">Parrainage</label>
\t\t\t\t<label for=\"transactionTab\" class=\"p-2  hover:bg-white hover:text-black [&[active]]:bg-white [&[active]]:text-black\" id=\"modalRadioTransaction\" ";
        // line 93
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusController("modal");
        yield " ";
        yield $this->extensions['Symfony\UX\StimulusBundle\Twig\StimulusTwigExtension']->renderStimulusAction("modal", "loadTransaction", "click");
        yield ">Transaction</label>


\t\t\t</div>

\t\t\t<!-- MODAL CORPS INFO -->
\t\t\t<div class=\"hidden has-checked:block max-h-[40vh] overflow-y-scroll relative\">
\t\t\t\t<input type=\"radio\" class=\"hidden\" name=\"modaltab\" id=\"infoTab\" checked>

\t\t\t\t<div
\t\t\t\t\tclass=\"flex\">

\t\t\t\t\t<!-- MODAL GAUCHE -->
\t\t\t\t\t<div
\t\t\t\t\t\tclass=\"p-2 pb-0 grow\">

\t\t\t\t\t\t<!-- MODAL ENTETE -->
\t\t\t\t\t\t<div class=\"font-bold pb-3\">
\t\t\t\t\t\t\t<div id=\"modalName\">NOM</div>
\t\t\t\t\t\t\t<div class=\"flex justify-between gap-2 \">
\t\t\t\t\t\t\t\t<div class=\"text-teal-600 text-sm\" id=\"modalCode\">Code</div>
\t\t\t\t\t\t\t\t<div class=\"size-14 border border-black/50 \">
\t\t\t\t\t\t\t\t\t<img src=\"\" alt=\"QR Code\" id=\"modalQRCode\" class=\"block size-full\">
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<!-- MODAL CORPS -->
\t\t\t\t\t\t<div class=\"border-l-2 border-teal-950 px-2 flex flex-col gap-1\">
\t\t\t\t\t\t\t<div>Parent:
\t\t\t\t\t\t\t\t<span id=\"modalParent\"></span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div>Cotisant:
\t\t\t\t\t\t\t\t<span id=\"modalCotisant\"></span>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<div>Membre:
\t\t\t\t\t\t\t\t<span id=\"modalMembre\"></span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>

\t\t\t\t\t</div>

\t\t\t\t\t<!-- MODAL DROITE -->
\t\t\t\t\t<div
\t\t\t\t\t\tclass=\"p-3 bg-teal-600 text-white\">

\t\t\t\t\t\t<!-- SIKLA CONTAINER -->
\t\t\t\t\t\t<div
\t\t\t\t\t\t\tclass=\"relative size-28 flex flex-col items-center text-center rounded-full overflow-hidden \">

\t\t\t\t\t\t\t<!-- SIKLA CENTRE -->
\t\t\t\t\t\t\t<div class=\"absolute top-1/2 left-1/2 size-1/5 z-30 -translate-1/2 rounded-full overflow-hidden bg-gray-600 border-2 border-teal-600\" id=\"modalSiklaCenter\"></div>

\t\t\t\t\t\t\t<!-- SIKLA INNER -->
\t\t\t\t\t\t\t<div class=\"absolute top-1/2 left-1/2 size-3/5 border-2 border-teal-600  z-20 -translate-1/2 flex flex-col rounded-full overflow-hidden\" id=\"modalSiklaInner\">
\t\t\t\t\t\t\t\t<div class=\"bg-gray-400 w-full h-1/2\"></div>
\t\t\t\t\t\t\t\t<div class=\"bg-gray-600 w-full h-1/2\"></div>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<!-- SIKLA OUTER -->
\t\t\t\t\t\t\t<div
\t\t\t\t\t\t\t\tclass=\"absolute top-1/2 left-1/2 size-full bg-gray-600 z-10 -translate-1/2 flex flex-wrap\" id=\"modalSiklaOuter\">
\t\t\t\t\t\t\t\t<!-- SIKLA ABOVE -->
\t\t\t\t\t\t\t\t<div class=\"w-1/2 h-1/2 bg-gray-600 \"></div>
\t\t\t\t\t\t\t\t<div class=\"w-1/2 h-1/2 bg-gray-400 \"></div>

\t\t\t\t\t\t\t\t<!-- SIKLA BELOW -->
\t\t\t\t\t\t\t\t<div class=\"w-1/2 h-1/2 bg-gray-400 \"></div>
\t\t\t\t\t\t\t\t<div class=\"w-1/2 h-1/2 bg-gray-600 \"></div>
\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t</div>

\t\t\t\t\t\t<!-- TITRE -->
\t\t\t\t\t\t<div class=\"text-center text-sm p-4\">ETAT SIKLA</div>

\t\t\t\t\t\t<!-- INFO SIKLA -->
\t\t\t\t\t\t<div class=\"text-sm flex flex-col gap-3\">
\t\t\t\t\t\t\t<div>Direct :
\t\t\t\t\t\t\t\t<span id=\"modalDirect\"></span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div>Indirect :
\t\t\t\t\t\t\t\t<span id=\"modalIndirect\"></span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>


\t\t\t\t\t</div>

\t\t\t\t</div>

\t\t\t\t<!-- MODAL FOOTER -->
\t\t\t\t<div class=\"p-1 pt-5 sticky bottom-0 bg-white z-40\">
\t\t\t\t\t<div class=\"border-t border-teal-950 text-xs flex justify-between gap-4\">
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<div id=\"modalEmail\"></div>
\t\t\t\t\t\t\t<div id=\"modalTelephone\"></div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t<div class=\"text-[10px]\">Utilisateur depuis
\t\t\t\t\t\t\t\t<span id=\"modalDate\"></span>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t</div>


\t\t\t<!-- MODAL CORPS PARRAINAGE  -->
\t\t\t<div class=\"p-2 hidden has-checked:block max-h-[40vh] overflow-y-scroll\">
\t\t\t\t<input type=\"radio\" class=\"hidden\" name=\"modaltab\" id=\"parrainageTab\">
\t\t\t\t<table class=\" text-sm border-collapse border border-teal-950 min-w-full\">
\t\t\t\t\t<thead class=\"bg-teal-700 text-white\">
\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<th class=\"border border-teal-950 p-2\">Date</th>
\t\t\t\t\t\t\t<th class=\"border border-teal-950 p-2\">Parrain&eacute;</th>
\t\t\t\t\t\t</tr>
\t\t\t\t\t</thead>
\t\t\t\t\t<tbody id=\"modalTableParrainage\"></tbody>
\t\t\t\t\t<tfoot class=\"sticky bottom-0  bg-teal-950 text-white p-2 \">
\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td>TOTAL PARRAIN&Eacute;</td>
\t\t\t\t\t\t\t<td id=\"modalParraine\"></td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t</tfoot>
\t\t\t\t</table>

\t\t\t</div>


\t\t\t<!-- MODAL CORPS TRANSACTION  -->
\t\t\t<div class=\"p-2 hidden has-checked:block max-h-[40vh] overflow-y-scroll\">
\t\t\t\t<input type=\"radio\" class=\"hidden\" name=\"modaltab\" id=\"transactionTab\">
\t\t\t\t<table class=\" text-sm border-collapse border border-teal-950 min-w-full max-h-[40vh] overflow-scroll max-w-screen\">
\t\t\t\t\t<thead class=\"bg-teal-700 text-white\">
\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<th class=\"border border-teal-950 p-2\">Date</th>
\t\t\t\t\t\t\t<th class=\"border border-teal-950 p-2\">Libellé</th>
\t\t\t\t\t\t\t<th class=\"border border-teal-950 p-2\">Montant</th>
\t\t\t\t\t\t</tr>
\t\t\t\t\t</thead>
\t\t\t\t\t<tbody id=\"modalTableTransaction\"></tbody>

\t\t\t\t\t<tfoot class=\"sticky bottom-0  bg-teal-950 text-white p-2\">
\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td colspan=\"2\">SOLDE</td>
\t\t\t\t\t\t\t<td id=\"modalPortefeuille\"></td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t</tfoot>
\t\t\t\t</table>

\t\t\t</div>


\t\t</div>
\t</div>


";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "database/index.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  248 => 93,  242 => 92,  236 => 91,  228 => 88,  209 => 71,  200 => 68,  196 => 67,  192 => 66,  188 => 65,  184 => 64,  180 => 63,  176 => 62,  172 => 61,  168 => 60,  164 => 59,  160 => 58,  156 => 56,  152 => 55,  126 => 31,  120 => 29,  118 => 28,  113 => 27,  111 => 26,  105 => 25,  99 => 22,  90 => 16,  82 => 11,  78 => 10,  74 => 9,  71 => 8,  64 => 7,  52 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "database/index.html.twig", "/home/anjara/Projects/Symfony/Import/Import GITTED/templates/database/index.html.twig");
    }
}

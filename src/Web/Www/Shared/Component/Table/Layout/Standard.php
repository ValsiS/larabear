<?php declare(strict_types=1);

namespace GuardsmanPanda\Larabear\Web\Www\Shared\Component\Table\Layout;

use GuardsmanPanda\Larabear\Infrastructure\Http\Service\Resp;
use Illuminate\View\Component;
use Illuminate\View\View;
use RuntimeException;

final class Standard extends Component {
    public string $classes = "min-w-full shadow";
    public string $headerClasses = "border-b-2 font-semibold text-left sticky top-0";
    public string $bodyClasses = "divide-y bg-white text-sm text-gray-600";

    public function __construct(public readonly string $color = 'gray') {
        $this->classes .= match ($color) {
            'gray' => '',
            'yellow' => ' shadow-yellow-300',
            default => throw new RuntimeException(message: 'Unknown color: ' . $color),
        };
        $this->headerClasses .= match ($color) {
            'gray' => ' border-gray-200 bg-gray-50',
            'yellow' => ' border-yellow-400 bg-yellow-300',
            default => throw new RuntimeException(message: 'Unknown color: ' . $color),
        };
        $this->bodyClasses .= match ($color) {
            'gray' => ' divide-gray-200',
            'yellow' => ' divide-yellow-200',
            default => throw new RuntimeException(message: 'Unknown color: ' . $color),
        };
    }

    public function render(): View {
        return Resp::view(view: 'bear::table.layout.standard');
    }
}

<?php declare(strict_types=1);

namespace Star;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'star')]
class StarCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('star')
            ->setDescription('Generate a star image')
            ->setHelp('Generate a star from provided arguments, save as PNG image')
        ;

        $this->addArgument('width', InputArgument::REQUIRED, 'Width of the output image');
        $this->addArgument('color', InputArgument::REQUIRED, 'Color of the star');
        $this->addArgument('points', InputArgument::REQUIRED, 'Number of star points');
        $this->addArgument('radius', InputArgument::REQUIRED, 'Number between 0.0 and 1.0, depth of the points');
        $this->addArgument('output', InputArgument::REQUIRED, 'Name of the output file');
        $this->addArgument('bgColor', InputArgument::OPTIONAL, 'Background image color in RBGInt format (default: white)', 16777215);
        $this->addArgument('borderColor', InputArgument::OPTIONAL, 'Star border color (no border if not specified)');
        $this->addArgument('borderWidth', InputArgument::OPTIONAL, 'Star border width (no border if not specified)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Star generated! :)');

        $size = intval($input->getArgument("width"));
        $starColor = intval($input->getArgument("color"));
        $spikeCount = intval($input->getArgument("points"));
        $depth = floatval($input->getArgument("radius"));
        $output = $input->getArgument("output");
        $bgColor = intval($input->getArgument("bgColor"));
        $borderColor = intval($input->getArgument("borderColor"));
        $borderWidth = intval($input->getArgument("borderWidth"));

        // Create an image canvas
        $canvas = imageCreateTrueColor($size, $size);

        // Fill background with color
        imagefill($canvas, 0, 0, $bgColor);

        // Compute values
        $centerPos = intval($size/2);
        $fullWidth = intval($size/2);
        $innerWidth = intval($fullWidth - $borderWidth);

        // If there's a border outline
        if ($input->hasArgument("borderColor") && $input->hasArgument("borderWidth"))
        {
            // Draw star with full width (border)
            $this->drawStar($canvas, $centerPos, $centerPos, $fullWidth, $spikeCount, $borderColor, $depth);

            // Draw inner star
            $this->drawStar($canvas, $centerPos, $centerPos, $innerWidth, $spikeCount, $starColor, $depth);
        }
        else
        {
            // Draw star with full width
            $this->drawStar($canvas, $centerPos, $centerPos, $fullWidth, $spikeCount, $starColor, $depth);
        }

        if (!str_ends_with($output, ".png"))
            $output .= ".png";

        // Output and free from memory
        header('Content-Type: image/png');
        imagepng($canvas, $output);
        imagedestroy($canvas);

        return 0;
    }

    private function drawStar($canvas, $center_x, $center_y, $width, $spikeCount, $color, $depth): void
    {
        $points = [];
        $currentPoint = 0;
        $rotation = 270; // Rotate by 270 deg, to make the spike to be in the top center, if spikeCount is odd

        $angleForOnePoint = 360 / ($spikeCount * 2);

        // For each pointer (inner and outer)
        for($angle = 0; $angle <= 360; $angle += $angleForOnePoint)
        {
            $currentPoint++;

            // If it's the inner (shorter) point, include depth
            if($currentPoint % 2 == 0)
            {
                $points[] = $center_y + ($width * $depth) * cos(deg2rad($rotation+$angle));
                $points[] = $center_x + ($width * $depth) * sin(deg2rad($rotation+$angle));
            }

            // Else just calculate position
            else
            {
                $points[] = $center_y + $width * cos(deg2rad($rotation+$angle));
                $points[] = $center_x + $width * sin(deg2rad($rotation+$angle));
            }
        }

        imagefilledpolygon($canvas, $points, $color);
    }
}

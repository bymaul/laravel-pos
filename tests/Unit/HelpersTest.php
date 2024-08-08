<?php

it('adds leading zeros to a value', function () {
    expect(addLeadingZero(5, 2))->toBe('05');
    expect(addLeadingZero(12, 4))->toBe('0012');
    expect(addLeadingZero('3', 3))->toBe('003');
    expect(addLeadingZero(0, 2))->toBe('00');
});

it('returns the value as is if no threshold is provided', function () {
    expect(addLeadingZero(5))->toBe('5');
    expect(addLeadingZero(12))->toBe('12');
    expect(addLeadingZero('3'))->toBe('3');
    expect(addLeadingZero(0))->toBe('0');
});
